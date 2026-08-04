<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataArticle;
use Illuminate\Http\Request;

class DataArticleAdminController extends Controller
{
    public function index()
    {
        $dataArticles = DataArticle::latest()->get();
        return view('admin.data-articles.index', compact('dataArticles'));
    }

    public function create()
    {
        return view('admin.data-articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/data-articles', 'public');
        }

        DataArticle::create($data);

        return redirect()->route('admin.data-articles.index')->with('success', 'Data artikel berhasil disimpan.');
    }

    public function edit(DataArticle $dataArticle)
    {
        return view('admin.data-articles.edit', compact('dataArticle'));
    }

    public function update(Request $request, DataArticle $dataArticle)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/data-articles', 'public');
        }

        $dataArticle->update($data);

        return redirect()->route('admin.data-articles.index')->with('success', 'Data artikel berhasil diperbarui.');
    }

    public function destroy(DataArticle $dataArticle)
    {
        $dataArticle->delete();
        return redirect()->route('admin.data-articles.index')->with('success', 'Data artikel berhasil dihapus.');
    }
}
