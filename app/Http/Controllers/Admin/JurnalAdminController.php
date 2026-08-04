<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JurnalAdminController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::latest()->get();
        return view('admin.journals.index', compact('jurnals'));
    }

    public function create()
    {
        return view('admin.journals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        if ($request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')->store('uploads/journals', 'public');
        }

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('uploads/journals', 'public');
        }

        Jurnal::create($data);

        return redirect()->route('admin.journals.index')->with('success', 'Jurnal berhasil disimpan.');
    }

    public function edit(Jurnal $journal)
    {
        return view('admin.journals.edit', compact('journal'));
    }

    public function update(Request $request, Jurnal $journal)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        if ($request->hasFile('file_pdf')) {
            if ($journal->file_pdf && Storage::disk('public')->exists($journal->file_pdf)) {
                Storage::disk('public')->delete($journal->file_pdf);
            }
            $data['file_pdf'] = $request->file('file_pdf')->store('uploads/journals', 'public');
        }

        if ($request->hasFile('gambar')) {
            if ($journal->gambar && Storage::disk('public')->exists($journal->gambar)) {
                Storage::disk('public')->delete($journal->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('uploads/journals', 'public');
        }

        $journal->update($data);

        return redirect()->route('admin.journals.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Jurnal $journal)
    {
        if ($journal->file_pdf && Storage::disk('public')->exists($journal->file_pdf)) {
            Storage::disk('public')->delete($journal->file_pdf);
        }

        if ($journal->gambar && Storage::disk('public')->exists($journal->gambar)) {
            Storage::disk('public')->delete($journal->gambar);
        }

        $journal->delete();
        return redirect()->route('admin.journals.index')->with('success', 'Jurnal berhasil dihapus.');
    }
}
