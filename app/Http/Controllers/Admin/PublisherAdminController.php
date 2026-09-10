<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PublisherAdminController extends Controller
{
    public function index()
    {
        $publishers = Publisher::latest()->get();

        return view(
            'admin.publishers.index',
            compact('publishers')
        );
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatePublisher($request);
        $newLogoPath = null;

        if ($request->hasFile('logo_or_cover')) {
            $newLogoPath = $request
                ->file('logo_or_cover')
                ->store('uploads/publishers', 'public');

            $data['logo_or_cover'] = $newLogoPath;
        }

        try {
            Publisher::create($data);
        } catch (Throwable $e) {
            if ($newLogoPath) {
                Storage::disk('public')->delete($newLogoPath);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.publishers.index')
            ->with('success', 'Publisher berhasil disimpan.');
    }

    public function show(Publisher $publisher)
    {
        return redirect()
            ->route('admin.publishers.edit', $publisher);
    }

    public function edit(Publisher $publisher)
    {
        return view(
            'admin.publishers.edit',
            compact('publisher')
        );
    }

    public function update(
        Request $request,
        Publisher $publisher
    ) {
        $data = $this->validatePublisher($request);

        $oldLogoPath = $publisher->logo_or_cover;
        $newLogoPath = null;

        if ($request->hasFile('logo_or_cover')) {
            $newLogoPath = $request
                ->file('logo_or_cover')
                ->store('uploads/publishers', 'public');

            $data['logo_or_cover'] = $newLogoPath;
        }

        try {
            $publisher->update($data);
        } catch (Throwable $e) {
            if ($newLogoPath) {
                Storage::disk('public')->delete($newLogoPath);
            }

            throw $e;
        }

        if (
            $newLogoPath &&
            $oldLogoPath &&
            $oldLogoPath !== $newLogoPath
        ) {
            Storage::disk('public')->delete($oldLogoPath);
        }

        return redirect()
            ->route('admin.publishers.index')
            ->with('success', 'Publisher berhasil diperbarui.');
    }

    public function destroy(Publisher $publisher)
    {
        $logoPath = $publisher->logo_or_cover;

        $publisher->delete();

        if ($logoPath) {
            Storage::disk('public')->delete($logoPath);
        }

        return redirect()
            ->route('admin.publishers.index')
            ->with('success', 'Publisher berhasil dihapus.');
    }

    private function validatePublisher(Request $request): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'about' => [
                'nullable',
                'string',
            ],

            'logo_or_cover' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],
        ], [
            'name.required' =>
                'Nama publisher wajib diisi.',

            'name.max' =>
                'Nama publisher maksimal 255 karakter.',

            'logo_or_cover.image' =>
                'Logo atau cover harus berupa gambar.',

            'logo_or_cover.mimes' =>
                'Format gambar harus JPG, JPEG, PNG, atau WebP.',

            'logo_or_cover.max' =>
                'Ukuran gambar maksimal 2 MB.',
        ]);
    }
}