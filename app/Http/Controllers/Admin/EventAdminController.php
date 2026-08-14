<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventAdminController extends Controller
{
    /**
     * Menampilkan semua event di admin.
     */
    public function index()
    {
        $events = Event::latest('start_date')->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Menampilkan form tambah event.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Menyimpan event baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:events,slug',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
        ]);

        // Buat slug otomatis kalau kosong
        $validated['slug'] = $validated['slug']
            ?? Str::slug($validated['title']);

        // Pastikan slug unik
        $originalSlug = $validated['slug'];
        $counter = 1;

        while (
            Event::where('slug', $validated['slug'])->exists()
        ) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Upload banner
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request
                ->file('banner_image')
                ->store('event-images', 'public');
        }

        // Checkbox featured
        $validated['is_featured'] = $request->boolean('is_featured');

        // Jika event baru dijadikan featured,
        // event featured sebelumnya dimatikan
        if ($validated['is_featured']) {
            Event::where('is_featured', true)
                ->update(['is_featured' => false]);
        }

        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail event di admin.
     */
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Menampilkan form edit event.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Mengupdate event.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:events,slug,' . $event->id,
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
        ]);

        // Buat slug otomatis kalau kosong
        $validated['slug'] = $validated['slug']
            ?? Str::slug($validated['title']);

        // Upload banner baru
        if ($request->hasFile('banner_image')) {

            // Hapus gambar lama
            if (
                $event->banner_image &&
                Storage::disk('public')->exists($event->banner_image)
            ) {
                Storage::disk('public')->delete($event->banner_image);
            }

            $validated['banner_image'] = $request
                ->file('banner_image')
                ->store('event-images', 'public');
        }

        // Checkbox featured
        $validated['is_featured'] = $request->boolean('is_featured');

        // Jika event ini dijadikan featured,
        // matikan featured lainnya
        if ($validated['is_featured']) {
            Event::where('id', '!=', $event->id)
                ->update(['is_featured' => false]);
        }

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Menghapus event.
     */
    public function destroy(Event $event)
    {
        // Hapus banner
        if (
            $event->banner_image &&
            Storage::disk('public')->exists($event->banner_image)
        ) {
            Storage::disk('public')->delete($event->banner_image);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}