<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;

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
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'nullable|date',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('uploads/conferences', 'public');
        }

        Conference::create($data);

        return redirect()->route('admin.conferences.index')->with('success', 'Konferensi berhasil disimpan.');
    }

    public function edit(Conference $conference)
    {
        return view('admin.conferences.edit', compact('conference'));
    }

    public function update(Request $request, Conference $conference)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'nullable|date',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('uploads/conferences', 'public');
        }

        $conference->update($data);

        return redirect()->route('admin.conferences.index')->with('success', 'Konferensi berhasil diperbarui.');
    }

    public function destroy(Conference $conference)
    {
        $conference->delete();
        return redirect()->route('admin.conferences.index')->with('success', 'Konferensi berhasil dihapus.');
    }
}
