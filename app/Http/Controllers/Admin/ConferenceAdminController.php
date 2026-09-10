<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ConferenceAdminController extends Controller
{
    public function index()
    {
        $conferences = Conference::latest()->get();

        return view('admin.conferences.index', compact('conferences'));
    }

    public function create()
    {
        return view('admin.conferences.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateConference($request);
        $data = $this->normalizeConferenceData($request, $data);
        $newPosterPath = null;

        if ($request->hasFile('poster')) {
            $newPosterPath = $request
                ->file('poster')
                ->store('uploads/conferences', 'public');

            $data['poster'] = $newPosterPath;
        }

        try {
            $conference = new Conference($data);

            if (Schema::hasColumn('conferences', 'title')) {
                $conference->title = $this->legacyTitle($data);
            }

            $conference->save();
        } catch (Throwable $e) {
            if ($newPosterPath) {
                Storage::disk('public')->delete($newPosterPath);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.conferences.index')
            ->with('success', 'Conference berhasil ditambahkan.');
    }

    public function show(Conference $conference)
    {
        return redirect()
            ->route('admin.conferences.edit', $conference);
    }

    public function edit(Conference $conference)
    {
        return view('admin.conferences.edit', compact('conference'));
    }

    public function update(Request $request, Conference $conference)
    {
        $data = $this->validateConference($request);
        $data = $this->normalizeConferenceData($request, $data);

        $oldPosterPath = $conference->poster;
        $newPosterPath = null;

        if ($request->hasFile('poster')) {
            $newPosterPath = $request
                ->file('poster')
                ->store('uploads/conferences', 'public');

            $data['poster'] = $newPosterPath;
        }

        try {
            $conference->fill($data);

            if (Schema::hasColumn('conferences', 'title')) {
                $conference->title = $this->legacyTitle($data);
            }

            $conference->save();
        } catch (Throwable $e) {
            if ($newPosterPath) {
                Storage::disk('public')->delete($newPosterPath);
            }

            throw $e;
        }

        if (
            $newPosterPath &&
            $oldPosterPath &&
            $oldPosterPath !== $newPosterPath
        ) {
            Storage::disk('public')->delete($oldPosterPath);
        }

        return redirect()
            ->route('admin.conferences.index')
            ->with('success', 'Conference berhasil diperbarui.');
    }

    public function destroy(Conference $conference)
    {
        $posterPath = $conference->poster;

        $conference->delete();

        if ($posterPath) {
            Storage::disk('public')->delete($posterPath);
        }

        return redirect()
            ->route('admin.conferences.index')
            ->with('success', 'Conference berhasil dihapus.');
    }

    private function validateConference(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'edition' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:50000'],
            'conference_url' => [
                'nullable',
                'url',
                'starts_with:http://,https://',
                'max:2048',
            ],
            'proceeding_url' => [
                'nullable',
                'url',
                'starts_with:http://,https://',
                'max:2048',
            ],
            'poster' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:6144',
            ],
        ], [
            'name.required' => 'Nama conference wajib diisi.',
            'edition.required' => 'Edisi conference wajib diisi.',
            'description.max' => 'Deskripsi conference terlalu panjang.',
            'conference_url.url' => 'URL conference harus berupa alamat website yang valid.',
            'conference_url.starts_with' => 'URL conference hanya boleh menggunakan HTTP atau HTTPS.',
            'proceeding_url.url' => 'URL prosiding harus berupa alamat website yang valid.',
            'proceeding_url.starts_with' => 'URL prosiding hanya boleh menggunakan HTTP atau HTTPS.',
            'poster.image' => 'Poster harus berupa file gambar.',
            'poster.mimes' => 'Poster harus menggunakan JPG, JPEG, PNG, atau WebP.',
            'poster.max' => 'Ukuran poster maksimal 6 MB.',
        ]);
    }

    private function normalizeConferenceData(
        Request $request,
        array $data
    ): array {
        $data['name'] = trim($data['name']);
        $data['edition'] = trim($data['edition']);

        $data['conference_url'] = $request->filled('conference_url')
            ? trim((string) $request->conference_url)
            : null;

        $data['proceeding_url'] = $request->filled('proceeding_url')
            ? trim((string) $request->proceeding_url)
            : null;

        return $data;
    }

    private function legacyTitle(array $data): string
    {
        return trim($data['name'] . ' ' . $data['edition']);
    }
}
