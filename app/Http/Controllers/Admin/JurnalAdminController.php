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
            'judul' => ['required', 'string', 'max:255'],
            'e_issn' => ['nullable', 'string', 'max:50'],
            'p_issn' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'journal_url' => ['nullable', 'url', 'max:2048'],
            'current_issue_url' => ['nullable', 'url', 'max:2048'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ], [
            'judul.required' => 'Nama jurnal wajib diisi.',
            'judul.max' => 'Nama jurnal maksimal 255 karakter.',

            'e_issn.max' => 'E-ISSN maksimal 50 karakter.',
            'p_issn.max' => 'P-ISSN maksimal 50 karakter.',

            'journal_url.url' => 'URL jurnal harus berupa alamat website yang valid.',
            'journal_url.max' => 'URL jurnal terlalu panjang.',

            'current_issue_url.url' => 'URL edisi terkini harus berupa alamat website yang valid.',
            'current_issue_url.max' => 'URL edisi terkini terlalu panjang.',

            'gambar.image' => 'Cover harus berupa file gambar.',
            'gambar.mimes' => 'Format cover harus JPG, JPEG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran cover maksimal 4 MB.',
        ]);

        $data['e_issn'] = $request->filled('e_issn')
            ? trim($request->e_issn)
            : null;

        $data['p_issn'] = $request->filled('p_issn')
            ? trim($request->p_issn)
            : null;

        $data['journal_url'] = $request->filled('journal_url')
            ? trim($request->journal_url)
            : null;

        $data['current_issue_url'] = $request->filled('current_issue_url')
            ? trim($request->current_issue_url)
            : null;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request
                ->file('gambar')
                ->store('uploads/journals', 'public');
        }

        Jurnal::create($data);

        return redirect()
            ->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil disimpan.');
    }

    public function edit(Jurnal $journal)
    {
        return view('admin.journals.edit', compact('journal'));
    }

    public function update(Request $request, Jurnal $journal)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'e_issn' => ['nullable', 'string', 'max:50'],
            'p_issn' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'journal_url' => ['nullable', 'url', 'max:2048'],
            'current_issue_url' => ['nullable', 'url', 'max:2048'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ], [
            'judul.required' => 'Nama jurnal wajib diisi.',
            'judul.max' => 'Nama jurnal maksimal 255 karakter.',

            'e_issn.max' => 'E-ISSN maksimal 50 karakter.',
            'p_issn.max' => 'P-ISSN maksimal 50 karakter.',

            'journal_url.url' => 'URL jurnal harus berupa alamat website yang valid.',
            'journal_url.max' => 'URL jurnal terlalu panjang.',

            'current_issue_url.url' => 'URL edisi terkini harus berupa alamat website yang valid.',
            'current_issue_url.max' => 'URL edisi terkini terlalu panjang.',

            'gambar.image' => 'Cover harus berupa file gambar.',
            'gambar.mimes' => 'Format cover harus JPG, JPEG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran cover maksimal 4 MB.',
        ]);

        $data['e_issn'] = $request->filled('e_issn')
            ? trim($request->e_issn)
            : null;

        $data['p_issn'] = $request->filled('p_issn')
            ? trim($request->p_issn)
            : null;

        $data['journal_url'] = $request->filled('journal_url')
            ? trim($request->journal_url)
            : null;

        $data['current_issue_url'] = $request->filled('current_issue_url')
            ? trim($request->current_issue_url)
            : null;

        if ($request->hasFile('gambar')) {
            if (
                $journal->gambar &&
                Storage::disk('public')->exists($journal->gambar)
            ) {
                Storage::disk('public')->delete($journal->gambar);
            }

            $data['gambar'] = $request
                ->file('gambar')
                ->store('uploads/journals', 'public');
        }

        $journal->update($data);

        return redirect()
            ->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Jurnal $journal)
    {
        if (
            $journal->gambar &&
            Storage::disk('public')->exists($journal->gambar)
        ) {
            Storage::disk('public')->delete($journal->gambar);
        }

        /*
        |--------------------------------------------------------------------------
        | LEGACY PDF
        |--------------------------------------------------------------------------
        |
        | Admin baru sudah tidak menggunakan PDF.
        | Tetapi jurnal lama mungkin masih punya file_pdf.
        | Saat jurnal dihapus, file lama tetap dibersihkan.
        |
        */

        if (
            $journal->file_pdf &&
            Storage::disk('public')->exists($journal->file_pdf)
        ) {
            Storage::disk('public')->delete($journal->file_pdf);
        }

        $journal->delete();

        return redirect()
            ->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}