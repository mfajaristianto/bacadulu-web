<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class PublisherAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = (string) $request->query('status', 'pending');

        if (!in_array($status, ['pending', 'approved', 'rejected', 'all'], true)) {
            $status = 'pending';
        }

        $books = Book::query()
            ->when(
                $status !== 'all',
                fn ($query) => $query->where('publisher_status', $status)
            )
            ->orderByRaw("CASE WHEN publisher_status = 'pending' THEN 0 WHEN publisher_status = 'rejected' THEN 1 ELSE 2 END")
            ->latest('updated_at')
            ->get();

        $counts = [
            'pending' => Book::query()->where('publisher_status', 'pending')->count(),
            'approved' => Book::query()->where('publisher_status', 'approved')->count(),
            'rejected' => Book::query()->where('publisher_status', 'rejected')->count(),
            'all' => Book::query()->count(),
        ];

        return view(
            'admin.publishers.index',
            compact('books', 'status', 'counts')
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

        if ($request->hasFile('cover')) {
            $coverPath = $request
                ->file('cover')
                ->store('book-covers', 'public');
        }

        try {
            $book = DB::transaction(function () use ($data, $coverPath) {
                return Book::create([
                    'title' => trim($data['title']),
                    'slug' => Book::makeSlug($data['title']),
                    'publisher' => trim($data['publisher']),
                    'author' => trim($data['author']),
                    'category' => $data['category'] ?? 'Umum',
                    'pages' => $data['pages'] ?? null,
                    'size' => $data['size'] ?? null,
                    'isbn' => $data['isbn'] ?? null,
                    'publish_year' => $data['publish_year'] ?? null,
                    'description' => $data['description'] ?? null,
                    'cover' => $coverPath,

                    // Kolom legacy price masih NOT NULL pada database lama.
                    // Nilai ini tidak pernah tampil di Bookstore selama format
                    // penjualan belum dipilih dan store_status belum approved.
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

            throw $e;
        }

        return redirect()
            ->route('admin.publishers.edit', $book->slug)
            ->with(
                'success',
                'Buku berhasil dibuat sebagai Pending. Periksa datanya lalu Approve jika sudah benar.'
            );
    }

    public function edit(Book $book)
    {
        return view(
            'admin.publishers.edit',
            compact('book')
        );
    }

    public function update(Request $request, Book $book)
    {
        $data = $this->validateBookMetadata($request);
        $oldCover = $book->cover;
        $newCover = null;

        if ($request->hasFile('cover')) {
            $newCover = $request
                ->file('cover')
                ->store('book-covers', 'public');

            $data['cover'] = $newCover;
        }

        try {
            DB::transaction(function () use ($book, $data) {
                $book->update([
                    'title' => trim($data['title']),
                    'publisher' => trim($data['publisher']),
                    'author' => trim($data['author']),
                    'category' => $data['category'] ?? 'Umum',
                    'pages' => $data['pages'] ?? null,
                    'size' => $data['size'] ?? null,
                    'isbn' => $data['isbn'] ?? null,
                    'publish_year' => $data['publish_year'] ?? null,
                    'description' => $data['description'] ?? null,
                    'cover' => $data['cover'] ?? $book->cover,
                ]);
            });
        } catch (Throwable $e) {
            if ($newCover) {
                Storage::disk('public')->delete($newCover);
            }

            throw $e;
        }

        if ($newCover && $oldCover && $oldCover !== $newCover) {
            Storage::disk('public')->delete($oldCover);
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
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
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
        ], [
            'title.required' => 'Judul buku wajib diisi.',
            'publisher.required' => 'Nama penerbit wajib diisi.',
            'author.required' => 'Nama penulis wajib diisi.',
            'cover.image' => 'Cover harus berupa gambar.',
            'cover.mimes' => 'Cover harus JPG, JPEG, PNG, atau WebP.',
            'cover.max' => 'Ukuran cover maksimal 8 MB.',
        ]);
    }

    private function ensurePublisherReady(Book $book): void
    {
        $missing = [];

        if (!trim((string) $book->title)) {
            $missing[] = 'judul';
        }

        if (!trim((string) $book->author)) {
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
