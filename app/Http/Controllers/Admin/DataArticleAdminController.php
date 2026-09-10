<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class DataArticleAdminController extends Controller
{
    public function index()
    {
        $dataArticles = DataArticle::latest()->get();

        return view(
            'admin.data-articles.index',
            compact('dataArticles')
        );
    }

    public function create()
    {
        return view('admin.data-articles.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateDataArticle($request);
        $newImagePath = null;

        if ($request->hasFile('image')) {
            $newImagePath = $request
                ->file('image')
                ->store('uploads/data-articles', 'public');

            $data['image'] = $newImagePath;
        }

        try {
            DataArticle::create($data);
        } catch (Throwable $e) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.data-articles.index')
            ->with('success', 'Data artikel berhasil disimpan.');
    }

    public function show(DataArticle $dataArticle)
    {
        return redirect()
            ->route('admin.data-articles.edit', $dataArticle);
    }

    public function edit(DataArticle $dataArticle)
    {
        return view(
            'admin.data-articles.edit',
            compact('dataArticle')
        );
    }

    public function update(
        Request $request,
        DataArticle $dataArticle
    ) {
        $data = $this->validateDataArticle($request);

        $oldImagePath = $dataArticle->image;
        $newImagePath = null;

        if ($request->hasFile('image')) {
            $newImagePath = $request
                ->file('image')
                ->store('uploads/data-articles', 'public');

            $data['image'] = $newImagePath;
        }

        try {
            $dataArticle->update($data);
        } catch (Throwable $e) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $e;
        }

        if (
            $newImagePath &&
            $oldImagePath &&
            $oldImagePath !== $newImagePath
        ) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.data-articles.index')
            ->with('success', 'Data artikel berhasil diperbarui.');
    }

    public function destroy(DataArticle $dataArticle)
    {
        $imagePath = $dataArticle->image;

        $dataArticle->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('admin.data-articles.index')
            ->with('success', 'Data artikel berhasil dihapus.');
    }

    private function validateDataArticle(Request $request): array
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],
        ], [
            'title.required' =>
                'Judul artikel wajib diisi.',

            'title.max' =>
                'Judul artikel maksimal 255 karakter.',

            'image.image' =>
                'File harus berupa gambar.',

            'image.mimes' =>
                'Format gambar harus JPG, JPEG, PNG, atau WebP.',

            'image.max' =>
                'Ukuran gambar maksimal 2 MB.',
        ]);
    }
}