<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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

        $data['name'] = trim($data['name']);
        $data['edition'] = trim($data['edition']);

        $data['conference_url'] = $request->filled('conference_url')
            ? trim($request->conference_url)
            : null;

        $data['proceeding_url'] = $request->filled('proceeding_url')
            ? trim($request->proceeding_url)
            : null;

        if ($request->hasFile('poster')) {
            $data['poster'] = $request
                ->file('poster')
                ->store('uploads/conferences', 'public');
        }

        $conference = new Conference($data);

        /*
        |--------------------------------------------------------------------------
        | LEGACY TITLE
        |--------------------------------------------------------------------------
        | Field title sudah tidak dipakai admin/public.
        | Kalau database lama masih punya kolom title wajib,
        | otomatis diisi dari nama + edisi agar insert tetap aman.
        */
        if (Schema::hasColumn('conferences', 'title')) {
            $conference->title = trim(
                $data['name'] . ' ' . $data['edition']
            );
        }

        $conference->save();

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

        $data['name'] = trim($data['name']);
        $data['edition'] = trim($data['edition']);

        $data['conference_url'] = $request->filled('conference_url')
            ? trim($request->conference_url)
            : null;

        $data['proceeding_url'] = $request->filled('proceeding_url')
            ? trim($request->proceeding_url)
            : null;

        if ($request->hasFile('poster')) {
            if (
                $conference->poster &&
                Storage::disk('public')->exists($conference->poster)
            ) {
                Storage::disk('public')->delete($conference->poster);
            }

            $data['poster'] = $request
                ->file('poster')
                ->store('uploads/conferences', 'public');
        }

        $conference->fill($data);

        if (Schema::hasColumn('conferences', 'title')) {
            $conference->title = trim(
                $data['name'] . ' ' . $data['edition']
            );
        }

        $conference->save();

        return redirect()
            ->route('admin.conferences.index')
            ->with('success', 'Conference berhasil diperbarui.');
    }

    public function destroy(Conference $conference)
    {
        if (
            $conference->poster &&
            Storage::disk('public')->exists($conference->poster)
        ) {
            Storage::disk('public')->delete($conference->poster);
        }

        $conference->delete();

        return redirect()
            ->route('admin.conferences.index')
            ->with('success', 'Conference berhasil dihapus.');
    }

    private function validateConference(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'edition' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'conference_url' => ['nullable', 'url', 'max:2048'],
            'proceeding_url' => ['nullable', 'url', 'max:2048'],
            'poster' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:6144',
            ],
        ], [
            'name.required' => 'Nama conference wajib diisi.',
            'edition.required' => 'Edisi conference wajib diisi.',
            'conference_url.url' => 'URL conference harus berupa alamat website yang valid.',
            'proceeding_url.url' => 'URL prosiding harus berupa alamat website yang valid.',
            'poster.image' => 'Poster harus berupa file gambar.',
            'poster.mimes' => 'Poster harus menggunakan JPG, JPEG, PNG, atau WebP.',
            'poster.max' => 'Ukuran poster maksimal 6 MB.',
        ]);
    }
}