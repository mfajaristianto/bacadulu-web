<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

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
        $data = $this->validateJournal($request);
        $newImagePath = null;

        $data = $this->normalizeJournalData($request, $data);

        if ($request->hasFile('gambar')) {
            $newImagePath = $request
                ->file('gambar')
                ->store('uploads/journals', 'public');

            $data['gambar'] = $newImagePath;
        }

        try {
            Jurnal::create($data);
        } catch (Throwable $e) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil disimpan.');
    }

    public function show(Jurnal $journal)
    {
        return redirect()->route(
            'admin.journals.edit',
            $journal
        );
    }

    public function edit(Jurnal $journal)
    {
        return view('admin.journals.edit', compact('journal'));
    }

    public function update(Request $request, Jurnal $journal)
    {
        $data = $this->validateJournal($request);
        $data = $this->normalizeJournalData($request, $data);

        $oldImagePath = $journal->gambar;
        $newImagePath = null;

        if ($request->hasFile('gambar')) {
            $newImagePath = $request
                ->file('gambar')
                ->store('uploads/journals', 'public');

            $data['gambar'] = $newImagePath;
        }

        try {
            $journal->update($data);
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
            ->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Jurnal $journal)
    {
        $imagePath = $journal->gambar;
        $legacyPdfPath = $journal->file_pdf;

        $journal->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        if ($legacyPdfPath) {
            Storage::disk('public')->delete($legacyPdfPath);
        }

        return redirect()
            ->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil dihapus.');
    }

    private function validateJournal(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'e_issn' => ['nullable', 'string', 'max:50'],
            'p_issn' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string', 'max:50000'],
            'journal_url' => [
                'nullable',
                'url',
                'starts_with:http://,https://',
                'max:2048',
            ],
            'current_issue_url' => [
                'nullable',
                'url',
                'starts_with:http://,https://',
                'max:2048',
            ],
            'gambar' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:4096',
            ],
        ], [
            'judul.required' => 'Nama jurnal wajib diisi.',
            'judul.max' => 'Nama jurnal maksimal 255 karakter.',
            'e_issn.max' => 'E-ISSN maksimal 50 karakter.',
            'p_issn.max' => 'P-ISSN maksimal 50 karakter.',
            'deskripsi.max' => 'Deskripsi jurnal terlalu panjang.',
            'journal_url.url' => 'URL jurnal harus berupa alamat website yang valid.',
            'journal_url.starts_with' => 'URL jurnal hanya boleh menggunakan HTTP atau HTTPS.',
            'journal_url.max' => 'URL jurnal terlalu panjang.',
            'current_issue_url.url' => 'URL edisi terkini harus berupa alamat website yang valid.',
            'current_issue_url.starts_with' => 'URL edisi terkini hanya boleh menggunakan HTTP atau HTTPS.',
            'current_issue_url.max' => 'URL edisi terkini terlalu panjang.',
            'gambar.image' => 'Cover harus berupa file gambar.',
            'gambar.mimes' => 'Format cover harus JPG, JPEG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran cover maksimal 4 MB.',
        ]);
    }

    private function normalizeJournalData(
        Request $request,
        array $data
    ): array {
        $data['judul'] = trim($data['judul']);

        $data['e_issn'] = $request->filled('e_issn')
            ? trim((string) $request->e_issn)
            : null;

        $data['p_issn'] = $request->filled('p_issn')
            ? trim((string) $request->p_issn)
            : null;

        $data['journal_url'] = $request->filled('journal_url')
            ? trim((string) $request->journal_url)
            : null;

        $data['current_issue_url'] = $request->filled('current_issue_url')
            ? trim((string) $request->current_issue_url)
            : null;

        return $data;
    }
}
