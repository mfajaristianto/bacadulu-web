<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherAdminController extends Controller
{
    public function index()
    {
        $publishers = Publisher::latest()->get();
        return view('admin.publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'logo_or_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logo_or_cover')) {
            $data['logo_or_cover'] = $request->file('logo_or_cover')->store('uploads/publishers', 'public');
        }

        Publisher::create($data);

        return redirect()->route('admin.publishers.index')->with('success', 'Publisher berhasil disimpan.');
    }

    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'logo_or_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logo_or_cover')) {
            $data['logo_or_cover'] = $request->file('logo_or_cover')->store('uploads/publishers', 'public');
        }

        $publisher->update($data);

        return redirect()->route('admin.publishers.index')->with('success', 'Publisher berhasil diperbarui.');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return redirect()->route('admin.publishers.index')->with('success', 'Publisher berhasil dihapus.');
    }
}
