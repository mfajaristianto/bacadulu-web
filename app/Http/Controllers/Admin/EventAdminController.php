<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class EventAdminController extends Controller
{
    public function index()
    {
        $events = Event::query()
            ->orderByDesc('start_date')
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.events.index',
            compact('events')
        );
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateEvent($request);
        $newBannerPath = null;

        if ($request->hasFile('banner_image')) {
            $newBannerPath = $request
                ->file('banner_image')
                ->store('events', 'public');
        }

        try {
            DB::transaction(function () use (
                $request,
                $validated,
                $newBannerPath
            ) {
                $isFeatured = $request->boolean('is_featured');

                if ($isFeatured) {
                    Event::query()
                        ->where('is_featured', true)
                        ->update(['is_featured' => false]);
                }

                $slugSource = !empty($validated['slug'])
                    ? $validated['slug']
                    : $validated['title'];

                Event::create([
                    'title' => trim($validated['title']),
                    'slug' => $this->generateUniqueSlug($slugSource),
                    'banner_image' => $newBannerPath,
                    'category' => !empty($validated['category'])
                        ? trim($validated['category'])
                        : null,
                    'location' => trim($validated['location']),
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'] ?? null,
                    'description' => trim($validated['description']),
                    'is_featured' => $isFeatured,
                ]);
            });
        } catch (Throwable $e) {
            if ($newBannerPath) {
                Storage::disk('public')->delete($newBannerPath);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    public function show(Event $event)
    {
        return redirect()
            ->route('admin.events.edit', $event);
    }

    public function edit(Event $event)
    {
        return view(
            'admin.events.edit',
            compact('event')
        );
    }

    public function update(
        Request $request,
        Event $event
    ) {
        $validated = $this->validateEvent($request);

        $oldBannerPath = $event->banner_image;
        $newBannerPath = null;

        if ($request->hasFile('banner_image')) {
            $newBannerPath = $request
                ->file('banner_image')
                ->store('events', 'public');
        }

        try {
            DB::transaction(function () use (
                $request,
                $validated,
                $event,
                $oldBannerPath,
                $newBannerPath
            ) {
                $isFeatured = $request->boolean('is_featured');

                if ($isFeatured) {
                    Event::query()
                        ->whereKeyNot($event->id)
                        ->where('is_featured', true)
                        ->update(['is_featured' => false]);
                }

                $slugSource = !empty($validated['slug'])
                    ? $validated['slug']
                    : $validated['title'];

                $event->update([
                    'title' => trim($validated['title']),
                    'slug' => $this->generateUniqueSlug(
                        $slugSource,
                        $event->id
                    ),
                    'banner_image' => $newBannerPath ?: $oldBannerPath,
                    'category' => !empty($validated['category'])
                        ? trim($validated['category'])
                        : null,
                    'location' => trim($validated['location']),
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'] ?? null,
                    'description' => trim($validated['description']),
                    'is_featured' => $isFeatured,
                ]);
            });
        } catch (Throwable $e) {
            if ($newBannerPath) {
                Storage::disk('public')->delete($newBannerPath);
            }

            throw $e;
        }

        if (
            $newBannerPath &&
            $oldBannerPath &&
            $oldBannerPath !== $newBannerPath
        ) {
            Storage::disk('public')->delete($oldBannerPath);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $bannerPath = $event->banner_image;

        $event->delete();

        if ($bannerPath) {
            Storage::disk('public')->delete($bannerPath);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    private function validateEvent(Request $request): array
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
            ],
            'banner_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'category' => [
                'nullable',
                'string',
                'max:100',
            ],
            'location' => [
                'required',
                'string',
                'max:255',
            ],
            'start_date' => [
                'required',
                'date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'description' => [
                'required',
                'string',
                'max:10000',
            ],
            'is_featured' => [
                'nullable',
                'boolean',
            ],
        ], [
            'title.required' => 'Judul event wajib diisi.',
            'title.max' => 'Judul event maksimal 255 karakter.',
            'banner_image.image' => 'Banner harus berupa gambar.',
            'banner_image.mimes' => 'Banner harus berformat JPG, JPEG, PNG, atau WebP.',
            'banner_image.max' => 'Ukuran banner maksimal 5 MB.',
            'location.required' => 'Lokasi event wajib diisi.',
            'start_date.required' => 'Tanggal dan waktu mulai wajib diisi.',
            'end_date.after_or_equal' => 'Waktu selesai tidak boleh lebih awal dari waktu mulai.',
            'description.required' => 'Deskripsi event wajib diisi.',
            'description.max' => 'Deskripsi event maksimal 10.000 karakter.',
        ]);
    }

    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'event';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Event::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->whereKeyNot($ignoreId)
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
