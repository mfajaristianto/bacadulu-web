<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformationAdminController extends Controller
{
    public function index()
    {
        $informations = Information::latest()->get();

        return view('admin.informations.index', compact('informations'));
    }

    public function create()
    {
        return view('admin.informations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/informations', 'public');
        }

        Information::create($data);

        return redirect()->route('admin.informations.index')->with('success', 'Informasi berhasil disimpan.');
    }

    public function edit(Information $information)
    {
        return view('admin.informations.edit', compact('information'));
    }

    public function update(Request $request, Information $information)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/informations', 'public');
        }

        $information->update($data);

        return redirect()->route('admin.informations.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy(Information $information)
    {
        $information->delete();

        return redirect()->route('admin.informations.index')->with('success', 'Informasi berhasil dihapus.');
    }
}
