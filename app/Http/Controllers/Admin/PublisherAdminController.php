<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\BacaPublisher\BacaPublisherSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class PublisherAdminController extends Controller
{
    public function index(
        Request $request,
        BacaPublisherSyncService $syncService
    ) {
        $status = (string) $request->query('status', 'pending');

        if (!in_array($status, ['pending', 'approved', 'rejected', 'all'], true)) {
            $status = 'pending';
        }

        $books = Book::query()
            ->when(
                $status !== 'all',
                fn ($query) => $query->where('publisher_status', $status)
            )
            ->orderByRaw("CASE WHEN has_pending_sync = 1 THEN 0 ELSE 1 END")
            ->orderByRaw("CASE WHEN publisher_status = 'pending' THEN 0 WHEN publisher_status = 'rejected' THEN 1 ELSE 2 END")
            ->latest('updated_at')
            ->get();

        $counts = [
            'pending' => Book::query()->where('publisher_status', 'pending')->count(),
            'approved' => Book::query()->where('publisher_status', 'approved')->count(),
            'rejected' => Book::query()->where('publisher_status', 'rejected')->count(),
            'all' => Book::query()->count(),
        ];

        $integration = [
            'configured' => $syncService->configured(),
            'external_books' => Book::query()
                ->where('source', 'bacapublisher')
                ->count(),
            'pending_updates' => Book::query()
                ->where('source', 'bacapublisher')
                ->where('has_pending_sync', true)
                ->count(),
            'last_sync' => Book::query()
                ->where('source', 'bacapublisher')
                ->whereNotNull('last_synced_at')
                ->max('last_synced_at'),
        ];

        return view(
            'admin.publishers.index',
            compact('books', 'status', 'counts', 'integration')
        );
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateBookMetadata($request);
        $coverPath = null;
        $previewPath = null;

        if ($request->hasFile('cover')) {
            $coverPath = $request
                ->file('cover')
                ->store('book-covers', 'public');
        }

        if ($request->hasFile('preview_pdf')) {
            $previewPath = $request
                ->file('preview_pdf')
                ->store('book-previews', 'public');
        }

        try {
            $book = DB::transaction(function () use ($data, $coverPath, $previewPath) {
                return Book::create([
                    'title' => trim($data['title']),
                    'slug' => Book::makeSlug($data['title']),
                    'publisher' => trim($data['publisher']),
                    ...$this->contributorFields($data),
                    'category' => $data['category'] ?? 'Umum',
                    'pages' => $data['pages'] ?? null,
                    'size' => $data['size'] ?? null,
                    'isbn' => $data['isbn'] ?? null,
                    'publish_year' => $data['publish_year'] ?? null,
                    'description' => $data['description'] ?? null,
                    'cover' => $coverPath,
                    'preview_pdf' => $previewPath,

                    // Kolom legacy price masih NOT NULL pada database lama.
                    'price' => 0,
                    'has_print' => false,
                    'print_stock' => 0,
                    'has_ebook' => false,

                    'source' => 'manual',
                    'publisher_status' => Book::STATUS_PENDING,
                    'publisher_review_note' => null,
                    'publisher_approved_at' => null,
                    'store_status' => Book::STATUS_PENDING,
                    'store_review_note' => null,
                    'store_approved_at' => null,
                ]);
            });
        } catch (Throwable $e) {
            if ($coverPath) {
                Storage::disk('public')->delete($coverPath);
            }

            if ($previewPath) {
                Storage::disk('public')->delete($previewPath);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.publishers.edit', $book->slug)
            ->with(
                'success',
                'Buku berhasil dibuat sebagai Pending. Periksa datanya lalu Approve jika sudah benar.'
            );
    }

    public function edit(
        Book $book,
        BacaPublisherSyncService $syncService
    ) {
        $pendingApiDiff = $syncService->pendingDiff($book);

        return view(
            'admin.publishers.edit',
            compact('book', 'pendingApiDiff')
        );
    }

    public function update(Request $request, Book $book)
    {
        $data = $this->validateBookMetadata($request);
        $oldCover = $book->cover;
        $newCover = null;
        $oldPreview = $book->preview_pdf;
        $newPreview = null;
        $removePreview = !empty($data['remove_preview_pdf']);

        if ($request->hasFile('cover')) {
            $newCover = $request
                ->file('cover')
                ->store('book-covers', 'public');

            $data['cover'] = $newCover;
        }

        if ($request->hasFile('preview_pdf')) {
            $newPreview = $request
                ->file('preview_pdf')
                ->store('book-previews', 'public');

            $data['preview_pdf'] = $newPreview;
            $removePreview = false;
        } elseif ($removePreview) {
            $data['preview_pdf'] = null;
        }

        try {
            DB::transaction(function () use ($book, $data) {
                $book->update([
                    'title' => trim($data['title']),
                    'publisher' => trim($data['publisher']),
                    ...$this->contributorFields($data),
                    'category' => $data['category'] ?? 'Umum',
                    'pages' => $data['pages'] ?? null,
                    'size' => $data['size'] ?? null,
                    'isbn' => $data['isbn'] ?? null,
                    'publish_year' => $data['publish_year'] ?? null,
                    'description' => $data['description'] ?? null,
                    'cover' => $data['cover'] ?? $book->cover,
                    'preview_pdf' => array_key_exists('preview_pdf', $data)
                        ? $data['preview_pdf']
                        : $book->preview_pdf,
                ]);
            });
        } catch (Throwable $e) {
            if ($newCover) {
                Storage::disk('public')->delete($newCover);
            }

            if ($newPreview) {
                Storage::disk('public')->delete($newPreview);
            }

            throw $e;
        }

        if ($newCover && $oldCover && $oldCover !== $newCover) {
            Storage::disk('public')->delete($oldCover);
        }

        if (($newPreview || $removePreview) && $oldPreview && $oldPreview !== $newPreview) {
            Storage::disk('public')->delete($oldPreview);
        }

        return redirect()
            ->route('admin.publishers.edit', $book->slug)
            ->with('success', 'Data buku Publisher berhasil diperbarui.');
    }

    public function approve(Book $book)
    {
        $this->ensurePublisherReady($book);

        $book->update([
            'publisher_status' => Book::STATUS_APPROVED,
            'publisher_review_note' => null,
            'publisher_approved_at' => now(),
        ]);

        return redirect()
            ->route('admin.publishers.index', ['status' => 'pending'])
            ->with('success', "\"{$book->title}\" sudah di-approve dan sekarang tampil di Publisher.");
    }

    public function reject(Request $request, Book $book)
    {
        $validated = $request->validate([
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $book->update([
            'publisher_status' => Book::STATUS_REJECTED,
            'publisher_review_note' => $validated['note'] ?? 'Ditolak oleh admin.',
            'publisher_approved_at' => null,
        ]);

        return redirect()
            ->route('admin.publishers.index', ['status' => 'rejected'])
            ->with('success', "\"{$book->title}\" dipindahkan ke status Rejected.");
    }

    public function markPending(Book $book)
    {
        $book->update([
            'publisher_status' => Book::STATUS_PENDING,
            'publisher_review_note' => null,
            'publisher_approved_at' => null,
        ]);

        return redirect()
            ->route('admin.publishers.index', ['status' => 'pending'])
            ->with('success', "\"{$book->title}\" dikembalikan ke Pending Review.");
    }

    public function sync(BacaPublisherSyncService $syncService)
    {
        try {
            $result = $syncService->sync();

            $message = sprintf(
                'Sync selesai: %d data diterima, %d buku baru, %d tanpa perubahan, %d update menunggu review, %d dilewati, %d gagal.',
                $result['received'],
                $result['created'],
                $result['unchanged'],
                $result['pending_updates'],
                $result['skipped'],
                $result['failed'],
            );

            return redirect()
                ->route('admin.publishers.index', ['status' => 'pending'])
                ->with('success', $message)
                ->with('sync_result', $result);
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.publishers.index')
                ->with('error', 'Sync BacaPublisher gagal: ' . $e->getMessage());
        }
    }

    public function testConnection(BacaPublisherSyncService $syncService)
    {
        try {
            $result = $syncService->testConnection();

            return redirect()
                ->route('admin.publishers.index')
                ->with(
                    'success',
                    'Koneksi BacaPublisher berhasil. API merespons dan mendeteksi sekitar '
                    . $result['items_max']
                    . ' submission.'
                );
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.publishers.index')
                ->with('error', 'Tes koneksi gagal: ' . $e->getMessage());
        }
    }

    public function applyApiUpdate(
        Book $book,
        BacaPublisherSyncService $syncService
    ) {
        try {
            $syncService->applyPendingUpdate($book);

            return redirect()
                ->route('admin.publishers.edit', $book->slug)
                ->with(
                    'success',
                    'Update dari BacaPublisher diterapkan. Status Publisher dikembalikan ke Pending untuk diperiksa sebelum Approve.'
                );
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.publishers.edit', $book->slug)
                ->with('error', 'Update API tidak dapat diterapkan: ' . $e->getMessage());
        }
    }

    public function ignoreApiUpdate(
        Book $book,
        BacaPublisherSyncService $syncService
    ) {
        try {
            $syncService->ignorePendingUpdate($book);

            return redirect()
                ->route('admin.publishers.edit', $book->slug)
                ->with(
                    'success',
                    'Update API diabaikan. Data hasil edit admin tetap dipertahankan.'
                );
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.publishers.edit', $book->slug)
                ->with('error', 'Update API tidak dapat diabaikan: ' . $e->getMessage());
        }
    }

    public function destroy(Book $book)
    {
        // Publisher dan Bookstore memakai record Book yang sama.
        // Karena itu aksi ini tidak menghapus master buku; hanya melepasnya
        // dari Publisher agar data/stock Bookstore tidak ikut hilang.
        $book->update([
            'publisher_status' => Book::STATUS_REJECTED,
            'publisher_review_note' => 'Dilepas dari Publisher oleh admin.',
            'publisher_approved_at' => null,
        ]);

        return redirect()
            ->route('admin.publishers.index', ['status' => 'rejected'])
            ->with('success', 'Buku dilepas dari Publisher tanpa menghapus data Bookstore.');
    }

    private function validateBookMetadata(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'authors' => ['required', 'array', 'min:1'],
            'authors.*' => ['nullable', 'string', 'max:255'],
            'author_display_mode' => ['required', 'in:inline,stacked,primary'],
            'primary_author' => ['nullable', 'string', 'max:255'],
            'editors' => ['nullable', 'array'],
            'editors.*' => ['nullable', 'string', 'max:255'],
            'editor_display_mode' => ['required', 'in:inline,stacked,primary'],
            'primary_editor' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'pages' => ['nullable', 'integer', 'min:1', 'max:100000'],
            'size' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:255'],
            'publish_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (now()->year + 2),
            ],
            'description' => ['nullable', 'string', 'max:100000'],
            'cover' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:8192',
            ],
            'preview_pdf' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:51200',
            ],
            'remove_preview_pdf' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Judul buku wajib diisi.',
            'publisher.required' => 'Nama penerbit wajib diisi.',
            'authors.required' => 'Minimal satu penulis wajib diisi.',
            'authors.array' => 'Data penulis tidak valid.',
            'cover.image' => 'Cover harus berupa gambar.',
            'cover.mimes' => 'Cover harus JPG, JPEG, PNG, atau WebP.',
            'cover.max' => 'Ukuran cover maksimal 8 MB.',
            'preview_pdf.file' => 'PDF preview gagal dibaca sebagai file upload. Pilih ulang file PDF lalu coba lagi.',
            'preview_pdf.mimes' => 'Preview buku harus berupa file PDF (.pdf).',
            'preview_pdf.max' => 'Ukuran PDF preview maksimal 50 MB.',
        ]);

        $data['remove_preview_pdf'] = $request->boolean('remove_preview_pdf');

        return $data;
    }

    private function contributorFields(array $data): array
    {
        $authors = Book::normalizeContributorNames($data['authors'] ?? []);
        $editors = Book::normalizeContributorNames($data['editors'] ?? []);

        if ($authors === []) {
            throw ValidationException::withMessages([
                'authors' => 'Minimal satu nama penulis wajib diisi.',
            ]);
        }

        $authorMode = in_array($data['author_display_mode'] ?? null, ['inline', 'stacked', 'primary'], true)
            ? $data['author_display_mode']
            : 'inline';
        $editorMode = in_array($data['editor_display_mode'] ?? null, ['inline', 'stacked', 'primary'], true)
            ? $data['editor_display_mode']
            : 'inline';

        $primaryAuthor = trim((string) ($data['primary_author'] ?? ''));
        if ($authorMode !== 'primary' || !in_array($primaryAuthor, $authors, true)) {
            $primaryAuthor = $authorMode === 'primary' ? ($authors[0] ?? null) : null;
        }

        $primaryEditor = trim((string) ($data['primary_editor'] ?? ''));
        if ($editorMode !== 'primary' || !in_array($primaryEditor, $editors, true)) {
            $primaryEditor = $editorMode === 'primary' ? ($editors[0] ?? null) : null;
        }

        return [
            'author' => implode(', ', $authors),
            'author_2' => null,
            'author_3' => null,
            'show_authors' => true,
            'author_names' => $authors,
            'author_display_mode' => $authorMode,
            'primary_author' => $primaryAuthor,
            'editor' => $editors !== [] ? implode(', ', $editors) : null,
            'editor_2' => null,
            'editor_3' => null,
            'show_editor' => $editors !== [],
            'show_editors' => $editors !== [],
            'editor_names' => $editors,
            'editor_display_mode' => $editorMode,
            'primary_editor' => $primaryEditor,
        ];
    }

    private function ensurePublisherReady(Book $book): void
    {
        $missing = [];

        if (!trim((string) $book->title)) {
            $missing[] = 'judul';
        }

        $author = trim((string) $book->author);
        if ($author === '' || mb_strtolower($author) === 'belum tersedia') {
            $missing[] = 'penulis';
        }

        if (!trim((string) $book->publisher)) {
            $missing[] = 'penerbit';
        }

        if ($missing) {
            throw ValidationException::withMessages([
                'approval' => 'Belum bisa approve. Lengkapi: ' . implode(', ', $missing) . '.',
            ]);
        }
    }
}
