<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class BookController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        Book::query()
            ->where(function ($query) {
                $query
                    ->whereNull('slug')
                    ->orWhere('slug', '');
            })
            ->get()
            ->each(function ($book) {
                $book->slug = Book::makeSlug(
                    $book->title,
                    $book->id
                );

                $book->save();
            });

        $status = (string) $request->query('status', 'all');

        if (!in_array($status, ['pending', 'approved', 'rejected', 'all'], true)) {
            $status = 'all';
        }

        $books = Book::query()
            ->when(
                $status !== 'all',
                fn ($query) => $query->where('store_status', $status)
            )
            ->orderByRaw("CASE WHEN store_status = 'pending' THEN 0 WHEN store_status = 'rejected' THEN 1 ELSE 2 END")
            ->latest('updated_at')
            ->get();

        $counts = [
            'pending' => Book::query()->where('store_status', Book::STATUS_PENDING)->count(),
            'approved' => Book::query()->where('store_status', Book::STATUS_APPROVED)->count(),
            'rejected' => Book::query()->where('store_status', Book::STATUS_REJECTED)->count(),
            'all' => Book::query()->count(),
        ];

        return view(
            'admin.books.index',
            compact('books', 'status', 'counts')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.books.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $coverPath = null;
        $previewPath = null;

        try {
            $this->validateBook($request);

            $hasPrint = $request->boolean('has_print');
            $hasEbook = $request->boolean('has_ebook');

            if (!$hasPrint && !$hasEbook) {
                throw ValidationException::withMessages([
                    'book_format' =>
                        'Pilih minimal satu format buku: Buku Cetak atau E-Book.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | BUKU CETAK
            |--------------------------------------------------------------------------
            */

            $printPrice = $hasPrint
                ? (float) $request->print_price
                : null;

            $printStock = $hasPrint
                ? (int) $request->print_stock
                : 0;

            $printIsbn =
                $hasPrint &&
                $request->filled('print_isbn')
                    ? trim((string) $request->print_isbn)
                    : null;

            $bookSize =
                $hasPrint &&
                $request->filled('size')
                    ? trim((string) $request->size)
                    : null;

            $hasPrintDiscount =
                $hasPrint &&
                $request->boolean('has_print_discount');

            $printDiscountPercent = $hasPrintDiscount
                ? (float) $request->print_discount_percent
                : null;

            $printDiscountedPrice = $hasPrintDiscount
                ? $this->calculateDiscount(
                    $printPrice,
                    $printDiscountPercent
                )
                : null;

            $printDiscountExpiresAt = $hasPrintDiscount
                ? now()->addMonth()
                : null;

            /*
            |--------------------------------------------------------------------------
            | E-BOOK
            |--------------------------------------------------------------------------
            */

            $ebookPrice = $hasEbook
                ? (float) $request->ebook_price
                : null;

            $ebookIsbn =
                $hasEbook &&
                $request->filled('ebook_isbn')
                    ? trim((string) $request->ebook_isbn)
                    : null;

            $hasEbookDiscount =
                $hasEbook &&
                $request->boolean('has_ebook_discount');

            $ebookDiscountPercent = $hasEbookDiscount
                ? (float) $request->ebook_discount_percent
                : null;

            $ebookDiscountedPrice = $hasEbookDiscount
                ? $this->calculateDiscount(
                    $ebookPrice,
                    $ebookDiscountPercent
                )
                : null;

            $ebookDiscountExpiresAt = $hasEbookDiscount
                ? now()->addMonth()
                : null;

            /*
            |--------------------------------------------------------------------------
            | LEGACY PRICE
            |--------------------------------------------------------------------------
            */

            if ($hasPrint) {
                $legacyPrice = $printPrice;
                $legacyDiscountedPrice =
                    $printDiscountedPrice;
                $legacyDiscountExpiresAt =
                    $printDiscountExpiresAt;
            } else {
                $legacyPrice = $ebookPrice;
                $legacyDiscountedPrice =
                    $ebookDiscountedPrice;
                $legacyDiscountExpiresAt =
                    $ebookDiscountExpiresAt;
            }

            /*
            |--------------------------------------------------------------------------
            | LEGACY ISBN
            |--------------------------------------------------------------------------
            */

            $legacyIsbn =
                $printIsbn ?: $ebookIsbn;

            /*
            |--------------------------------------------------------------------------
            | COVER
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('cover')) {
                $coverPath = $this->storeCover(
                    $request->file('cover')
                );
            }

            if ($request->hasFile('preview_pdf')) {
                $previewPath = $request
                    ->file('preview_pdf')
                    ->store('book-previews', 'public');
            }

            /*
            |--------------------------------------------------------------------------
            | SAVE
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use (
                $request,
                $hasPrint,
                $hasEbook,
                $printPrice,
                $printStock,
                $printIsbn,
                $bookSize,
                $printDiscountPercent,
                $printDiscountedPrice,
                $printDiscountExpiresAt,
                $ebookPrice,
                $ebookIsbn,
                $ebookDiscountPercent,
                $ebookDiscountedPrice,
                $ebookDiscountExpiresAt,
                $legacyPrice,
                $legacyDiscountedPrice,
                $legacyDiscountExpiresAt,
                $legacyIsbn,
                $coverPath,
                $previewPath
            ) {
                $book = Book::create([
                    /*
                    |--------------------------------------------------------------
                    | UMUM
                    |--------------------------------------------------------------
                    */

                    'title' =>
                        trim($request->title),

                    'slug' =>
                        Book::makeSlug(
                            $request->title
                        ),

                    'publisher' =>
                        trim($request->publisher),
                    ...$this->contributorFields($request),

                    'category' =>
                        $request->filled('category')
                            ? trim($request->category)
                            : 'Umum',

                    'pages' =>
                        $request->pages,

                    'publish_year' =>
                        $request->publish_year,

                    'description' =>
                        $request->description,

                    'cover' =>
                        $coverPath,

                    'preview_pdf' =>
                        $previewPath,

                    /*
                    |--------------------------------------------------------------
                    | WORKFLOW
                    |--------------------------------------------------------------
                    */

                    'source' =>
                        'manual',

                    'publisher_status' =>
                        Book::STATUS_APPROVED,

                    'publisher_approved_at' =>
                        now(),

                    'store_status' =>
                        Book::STATUS_APPROVED,

                    'store_approved_at' =>
                        now(),

                    /*
                    |--------------------------------------------------------------
                    | CETAK
                    |--------------------------------------------------------------
                    */

                    'has_print' =>
                        $hasPrint,

                    'print_price' =>
                        $printPrice,

                    'print_stock' =>
                        $printStock,

                    'print_isbn' =>
                        $printIsbn,

                    'size' =>
                        $bookSize,

                    'print_discount_percent' =>
                        $printDiscountPercent,

                    'print_discounted_price' =>
                        $printDiscountedPrice,

                    'print_discount_expires_at' =>
                        $printDiscountExpiresAt,

                    /*
                    |--------------------------------------------------------------
                    | E-BOOK
                    |--------------------------------------------------------------
                    */

                    'has_ebook' =>
                        $hasEbook,

                    'ebook_price' =>
                        $ebookPrice,

                    'ebook_isbn' =>
                        $ebookIsbn,

                    'ebook_discount_percent' =>
                        $ebookDiscountPercent,

                    'ebook_discounted_price' =>
                        $ebookDiscountedPrice,

                    'ebook_discount_expires_at' =>
                        $ebookDiscountExpiresAt,

                    /*
                    |--------------------------------------------------------------
                    | LEGACY
                    |--------------------------------------------------------------
                    */

                    'price' =>
                        $legacyPrice,

                    'discounted_price' =>
                        $legacyDiscountedPrice,

                    'discount_expires_at' =>
                        $legacyDiscountExpiresAt,

                    'isbn' =>
                        $legacyIsbn,
                ]);

                /*
                |--------------------------------------------------------------------------
                | STOK AWAL
                |--------------------------------------------------------------------------
                */

                if (
                    $hasPrint &&
                    $printStock > 0
                ) {
                    $book
                        ->stockMovements()
                        ->create([
                            'user_id' =>
                                auth('admin')->id(),

                            'type' =>
                                'initial',

                            'quantity_change' =>
                                $printStock,

                            'stock_before' =>
                                0,

                            'stock_after' =>
                                $printStock,

                            'note' =>
                                'Stok awal saat buku dibuat.',
                        ]);
                }
            });

            return redirect()
                ->route('admin.books.index')
                ->with(
                    'success',
                    'Buku berhasil ditambahkan!'
                );
        } catch (ValidationException $e) {
            if ($coverPath) {
                Storage::disk('public')
                    ->delete($coverPath);
            }

            if ($previewPath) {
                Storage::disk('public')
                    ->delete($previewPath);
            }

            return back()
                ->withErrors(
                    $e->errors()
                )
                ->withInput(
                    $request->except([
                        '_token',
                        'cover',
                        'preview_pdf',
                    ])
                );
        } catch (Throwable $e) {
            if ($coverPath) {
                Storage::disk('public')
                    ->delete($coverPath);
            }

            if ($previewPath) {
                Storage::disk('public')
                    ->delete($previewPath);
            }

            report($e);

            return back()
                ->withErrors([
                    'general' =>
                        config('app.debug')
                            ? 'Buku gagal disimpan: ' . $e->getMessage()
                            : 'Buku gagal disimpan. Silakan coba kembali.',
                ])
                ->withInput(
                    $request->except([
                        '_token',
                        'cover',
                        'preview_pdf',
                    ])
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    /**
     * Resource show diarahkan ke form edit karena CMS buku tidak memiliki
     * halaman detail admin terpisah. Ini mencegah route resource /books/{book}
     * berakhir pada method yang tidak ada.
     */
    public function show(Book $book)
    {
        return redirect()->route(
            'admin.books.edit',
            $book
        );
    }

    public function edit(Book $book)
    {
        $book->load(
            'stockMovements.user'
        );

        return view(
            'admin.books.edit',
            compact('book')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Book $book
    ) {
        $oldCoverPath =
            $book->cover;

        $newCoverPath =
            null;

        $oldPreviewPath =
            $book->preview_pdf;

        $newPreviewPath =
            null;

        $removePreview =
            $request->boolean('remove_preview_pdf');

        try {
            $this->validateBook($request);

            $hasPrint =
                $request->boolean('has_print');

            $hasEbook =
                $request->boolean('has_ebook');

            if (!$hasPrint && !$hasEbook) {
                throw ValidationException::withMessages([
                    'book_format' =>
                        'Pilih minimal satu format buku: Buku Cetak atau E-Book.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | CETAK
            |--------------------------------------------------------------------------
            */

            $oldPrintStock =
                (int) $book->print_stock;

            $printPrice =
                $hasPrint
                    ? (float) $request->print_price
                    : null;

            $printStock =
                $hasPrint
                    ? (int) $request->print_stock
                    : 0;

            $printIsbn =
                $hasPrint &&
                $request->filled('print_isbn')
                    ? trim(
                        (string) $request->print_isbn
                    )
                    : null;

            $bookSize =
                $hasPrint &&
                $request->filled('size')
                    ? trim(
                        (string) $request->size
                    )
                    : null;

            $hasPrintDiscount =
                $hasPrint &&
                $request->boolean(
                    'has_print_discount'
                );

            $printDiscountPercent =
                $hasPrintDiscount
                    ? (float) $request->print_discount_percent
                    : null;

            $printDiscountedPrice =
                $hasPrintDiscount
                    ? $this->calculateDiscount(
                        $printPrice,
                        $printDiscountPercent
                    )
                    : null;

            $printDiscountExpiresAt =
                $hasPrintDiscount
                    ? now()->addMonth()
                    : null;

            /*
            |--------------------------------------------------------------------------
            | E-BOOK
            |--------------------------------------------------------------------------
            */

            $ebookPrice =
                $hasEbook
                    ? (float) $request->ebook_price
                    : null;

            $ebookIsbn =
                $hasEbook &&
                $request->filled('ebook_isbn')
                    ? trim(
                        (string) $request->ebook_isbn
                    )
                    : null;

            $hasEbookDiscount =
                $hasEbook &&
                $request->boolean(
                    'has_ebook_discount'
                );

            $ebookDiscountPercent =
                $hasEbookDiscount
                    ? (float) $request->ebook_discount_percent
                    : null;

            $ebookDiscountedPrice =
                $hasEbookDiscount
                    ? $this->calculateDiscount(
                        $ebookPrice,
                        $ebookDiscountPercent
                    )
                    : null;

            $ebookDiscountExpiresAt =
                $hasEbookDiscount
                    ? now()->addMonth()
                    : null;

            /*
            |--------------------------------------------------------------------------
            | LEGACY PRICE
            |--------------------------------------------------------------------------
            */

            if ($hasPrint) {
                $legacyPrice =
                    $printPrice;

                $legacyDiscountedPrice =
                    $printDiscountedPrice;

                $legacyDiscountExpiresAt =
                    $printDiscountExpiresAt;
            } else {
                $legacyPrice =
                    $ebookPrice;

                $legacyDiscountedPrice =
                    $ebookDiscountedPrice;

                $legacyDiscountExpiresAt =
                    $ebookDiscountExpiresAt;
            }

            /*
            |--------------------------------------------------------------------------
            | LEGACY ISBN
            |--------------------------------------------------------------------------
            */

            $legacyIsbn =
                $printIsbn ?: $ebookIsbn;

            /*
            | Untuk data lama yang memiliki kedua format tetapi belum
            | dipisahkan ISBN-nya, pertahankan ISBN lama sampai admin
            | menentukan ISBN format masing-masing.
            */

            if (
                $legacyIsbn === null &&
                $hasPrint &&
                $hasEbook &&
                $book->isbn
            ) {
                $legacyIsbn =
                    $book->isbn;
            }

            /*
            |--------------------------------------------------------------------------
            | COVER
            |--------------------------------------------------------------------------
            */

            $coverPath =
                $oldCoverPath;

            if ($request->hasFile('cover')) {
                $newCoverPath =
                    $this->storeCover(
                        $request->file('cover')
                    );

                $coverPath =
                    $newCoverPath;
            }

            $previewPath =
                $oldPreviewPath;

            if ($request->hasFile('preview_pdf')) {
                $newPreviewPath = $request
                    ->file('preview_pdf')
                    ->store('book-previews', 'public');

                $previewPath =
                    $newPreviewPath;

                $removePreview = false;
            } elseif ($removePreview) {
                $previewPath = null;
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE DATABASE
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use (
                $request,
                $book,
                $hasPrint,
                $hasEbook,
                $oldPrintStock,
                $printPrice,
                $printStock,
                $printIsbn,
                $bookSize,
                $printDiscountPercent,
                $printDiscountedPrice,
                $printDiscountExpiresAt,
                $ebookPrice,
                $ebookIsbn,
                $ebookDiscountPercent,
                $ebookDiscountedPrice,
                $ebookDiscountExpiresAt,
                $legacyPrice,
                $legacyDiscountedPrice,
                $legacyDiscountExpiresAt,
                $legacyIsbn,
                $coverPath,
                $previewPath
            ) {
                $book->update([
                    /*
                    |--------------------------------------------------------------
                    | UMUM
                    |--------------------------------------------------------------
                    */

                    'title' =>
                        trim($request->title),

                    'slug' =>
                        Book::makeSlug(
                            $request->title,
                            $book->id
                        ),

                    'publisher' =>
                        trim($request->publisher),
                    ...$this->contributorFields($request),

                    'category' =>
                        $request->filled('category')
                            ? trim($request->category)
                            : 'Umum',

                    'pages' =>
                        $request->pages,

                    'publish_year' =>
                        $request->publish_year,

                    'description' =>
                        $request->description,

                    'cover' =>
                        $coverPath,

                    'preview_pdf' =>
                        $previewPath,

                    /*
                    |--------------------------------------------------------------
                    | CETAK
                    |--------------------------------------------------------------
                    */

                    'has_print' =>
                        $hasPrint,

                    'print_price' =>
                        $printPrice,

                    'print_stock' =>
                        $printStock,

                    'print_isbn' =>
                        $printIsbn,

                    'size' =>
                        $bookSize,

                    'print_discount_percent' =>
                        $printDiscountPercent,

                    'print_discounted_price' =>
                        $printDiscountedPrice,

                    'print_discount_expires_at' =>
                        $printDiscountExpiresAt,

                    /*
                    |--------------------------------------------------------------
                    | E-BOOK
                    |--------------------------------------------------------------
                    */

                    'has_ebook' =>
                        $hasEbook,

                    'ebook_price' =>
                        $ebookPrice,

                    'ebook_isbn' =>
                        $ebookIsbn,

                    'ebook_discount_percent' =>
                        $ebookDiscountPercent,

                    'ebook_discounted_price' =>
                        $ebookDiscountedPrice,

                    'ebook_discount_expires_at' =>
                        $ebookDiscountExpiresAt,

                    /*
                    |--------------------------------------------------------------
                    | LEGACY
                    |--------------------------------------------------------------
                    */

                    'price' =>
                        $legacyPrice,

                    'discounted_price' =>
                        $legacyDiscountedPrice,

                    'discount_expires_at' =>
                        $legacyDiscountExpiresAt,

                    'isbn' =>
                        $legacyIsbn,
                ]);

                /*
                |--------------------------------------------------------------------------
                | RIWAYAT PERUBAHAN STOK
                |--------------------------------------------------------------------------
                */

                if (
                    $oldPrintStock !==
                    $printStock
                ) {
                    $book
                        ->stockMovements()
                        ->create([
                            'user_id' =>
                                auth('admin')->id(),

                            'type' =>
                                'adjustment',

                            'quantity_change' =>
                                $printStock -
                                $oldPrintStock,

                            'stock_before' =>
                                $oldPrintStock,

                            'stock_after' =>
                                $printStock,

                            'note' =>
                                'Penyesuaian stok melalui form edit buku.',
                        ]);
                }
            });

            /*
            |--------------------------------------------------------------------------
            | HAPUS COVER LAMA
            |--------------------------------------------------------------------------
            */

            if (
                $newCoverPath &&
                $oldCoverPath &&
                $newCoverPath !==
                    $oldCoverPath
            ) {
                Storage::disk('public')
                    ->delete(
                        $oldCoverPath
                    );
            }

            if (
                ($newPreviewPath || $removePreview) &&
                $oldPreviewPath &&
                $oldPreviewPath !== $newPreviewPath
            ) {
                Storage::disk('public')
                    ->delete($oldPreviewPath);
            }

            return redirect()
                ->route('admin.books.index')
                ->with(
                    'success',
                    'Buku berhasil diperbarui!'
                );
        } catch (ValidationException $e) {
            if ($newCoverPath) {
                Storage::disk('public')
                    ->delete(
                        $newCoverPath
                    );
            }

            if ($newPreviewPath) {
                Storage::disk('public')->delete($newPreviewPath);
            }

            return back()
                ->withErrors(
                    $e->errors()
                )
                ->withInput(
                    $request->except([
                        '_token',
                        '_method',
                        'cover',
                        'preview_pdf',
                    ])
                );
        } catch (Throwable $e) {
            if ($newCoverPath) {
                Storage::disk('public')
                    ->delete(
                        $newCoverPath
                    );
            }

            if ($newPreviewPath) {
                Storage::disk('public')->delete($newPreviewPath);
            }

            report($e);

            return back()
                ->withErrors([
                    'general' =>
                        config('app.debug')
                            ? 'Buku gagal diperbarui: ' . $e->getMessage()
                            : 'Buku gagal diperbarui. Silakan coba kembali.',
                ])
                ->withInput(
                    $request->except([
                        '_token',
                        '_method',
                        'cover',
                        'preview_pdf',
                    ])
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | BOOKSTORE APPROVAL
    |--------------------------------------------------------------------------
    */

    public function approveStore(Book $book)
    {
        $hasSellableFormat = (
            $book->has_print &&
            $book->print_price !== null
        ) || (
            $book->has_ebook &&
            $book->ebook_price !== null
        );

        if (!$hasSellableFormat) {
            throw ValidationException::withMessages([
                'approval' =>
                    'Belum bisa approve Bookstore. Edit buku terlebih dahulu dan aktifkan minimal satu format beserta harganya.',
            ]);
        }

        DB::transaction(function () use ($book) {
            $approvedAt = now();

            $updates = [
                'store_status' => Book::STATUS_APPROVED,
                'store_review_note' => null,
                'store_approved_at' => $approvedAt,
            ];

            // Buku yang sudah layak dijual harus ikut tampil di katalog
            // BacaPublisher. Status rejected tetap dihormati karena berarti
            // admin sengaja melepas buku dari Publisher.
            if ($book->publisher_status !== Book::STATUS_REJECTED) {
                $updates['publisher_status'] = Book::STATUS_APPROVED;
                $updates['publisher_review_note'] = null;
                $updates['publisher_approved_at'] = $book->publisher_approved_at ?: $approvedAt;
            }

            $book->update($updates);
        });

        return redirect()
            ->route('admin.books.index', ['status' => 'pending'])
            ->with(
                'success',
                "\"{$book->title}\" sudah di-approve dan sekarang tampil di Bookstore serta katalog BacaPublisher."
            );
    }

    public function rejectStore(Request $request, Book $book)
    {
        $validated = $request->validate([
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $book->update([
            'store_status' => Book::STATUS_REJECTED,
            'store_review_note' => $validated['note'] ?? 'Ditolak oleh admin.',
            'store_approved_at' => null,
        ]);

        return redirect()
            ->route('admin.books.index', ['status' => 'rejected'])
            ->with(
                'success',
                "\"{$book->title}\" dipindahkan ke status Rejected Bookstore."
            );
    }

    public function markStorePending(Book $book)
    {
        $book->update([
            'store_status' => Book::STATUS_PENDING,
            'store_review_note' => null,
            'store_approved_at' => null,
        ]);

        return redirect()
            ->route('admin.books.index', ['status' => 'pending'])
            ->with(
                'success',
                "\"{$book->title}\" dikembalikan ke Pending Bookstore."
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH STOK
    |--------------------------------------------------------------------------
    */

    public function addStock(
        Request $request,
        Book $book
    ) {
        $validated = $request->validate([
            'quantity' =>
                'required|integer|min:1|max:1000000',

            'note' =>
                'nullable|string|max:500',
        ]);

        DB::transaction(function () use (
            $book,
            $validated
        ) {
            $lockedBook = Book::query()
                ->whereKey($book->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$lockedBook->has_print) {
                throw ValidationException::withMessages([
                    'quantity' =>
                        'Buku ini tidak memiliki format Buku Cetak.',
                ]);
            }

            $before =
                (int) $lockedBook->print_stock;

            $quantity =
                (int) $validated['quantity'];

            $after =
                $before + $quantity;

            $lockedBook->update([
                'print_stock' => $after,
            ]);

            $lockedBook
                ->stockMovements()
                ->create([
                    'user_id' =>
                        auth('admin')->id(),

                    'type' =>
                        'restock',

                    'quantity_change' =>
                        $quantity,

                    'stock_before' =>
                        $before,

                    'stock_after' =>
                        $after,

                    'note' =>
                        $validated['note']
                        ?? 'Penambahan stok Buku Cetak.',
                ]);
        });

        return redirect()
            ->route(
                'admin.books.edit',
                $book->slug
            )
            ->with(
                'success',
                'Stok Buku Cetak berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CATAT PENJUALAN
    |--------------------------------------------------------------------------
    */

    public function recordSale(
        Request $request,
        Book $book
    ) {
        $validated = $request->validate([
            'quantity' =>
                'required|integer|min:1|max:1000000',

            'note' =>
                'nullable|string|max:500',
        ]);

        DB::transaction(function () use (
            $book,
            $validated
        ) {
            $lockedBook = Book::query()
                ->whereKey($book->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$lockedBook->has_print) {
                throw ValidationException::withMessages([
                    'quantity' =>
                        'Buku ini tidak memiliki format Buku Cetak.',
                ]);
            }

            $before =
                (int) $lockedBook->print_stock;

            $quantity =
                (int) $validated['quantity'];

            if ($quantity > $before) {
                throw ValidationException::withMessages([
                    'quantity' =>
                        "Jumlah penjualan melebihi stok yang tersedia ({$before} buku).",
                ]);
            }

            $after =
                $before - $quantity;

            $lockedBook->update([
                'print_stock' =>
                    $after,
            ]);

            $lockedBook
                ->stockMovements()
                ->create([
                    'user_id' =>
                        auth('admin')->id(),

                    'type' =>
                        'sale',

                    'quantity_change' =>
                        -$quantity,

                    'stock_before' =>
                        $before,

                    'stock_after' =>
                        $after,

                    'note' =>
                        $validated['note']
                        ?? 'Penjualan Buku Cetak dikonfirmasi CS.',
                ]);
        });

        return redirect()
            ->route(
                'admin.books.edit',
                $book->slug
            )
            ->with(
                'success',
                'Penjualan berhasil dicatat dan stok otomatis berkurang.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Book $book)
    {
        $coverPath =
            $book->cover;

        $previewPath =
            $book->preview_pdf;

        DB::transaction(function () use ($book) {
            $book->delete();
        });

        if ($coverPath) {
            Storage::disk('public')
                ->delete(
                    $coverPath
                );
        }

        if ($previewPath) {
            Storage::disk('public')->delete($previewPath);
        }

        return redirect()
            ->route('admin.books.index')
            ->with(
                'success',
                'Buku berhasil dihapus!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    private function validateBook(
        Request $request
    ): void {
        $request->validate([
            /*
            |--------------------------------------------------------------
            | UMUM
            |--------------------------------------------------------------
            */

            'title' =>
                'required|string|max:255',

            'publisher' =>
                'required|string|max:255',
            'authors' =>
                'required|array|min:1',

            'authors.*' =>
                'nullable|string|max:255',

            'author_display_mode' =>
                'required|in:inline,stacked,primary',

            'primary_author' =>
                'nullable|string|max:255',

            'editors' =>
                'nullable|array',

            'editors.*' =>
                'nullable|string|max:255',

            'editor_display_mode' =>
                'required|in:inline,stacked,primary',

            'primary_editor' =>
                'nullable|string|max:255',

            'category' =>
                'nullable|string|max:255',

            'pages' =>
                'nullable|integer|min:1|max:100000',

            'publish_year' =>
                'nullable|integer|min:1900|max:' .
                (now()->year + 2),

            'description' =>
                'nullable|string',

            /*
            |--------------------------------------------------------------
            | FORMAT
            |--------------------------------------------------------------
            */

            'has_print' =>
                'nullable|boolean',

            'has_ebook' =>
                'nullable|boolean',

            /*
            |--------------------------------------------------------------
            | CETAK
            |--------------------------------------------------------------
            */

            'print_isbn' =>
                'nullable|string|max:255',

            'size' =>
                'nullable|string|max:255',

            'print_price' =>
                'nullable|required_if:has_print,1|numeric|min:0.01|max:999999999999.99',

            'print_stock' =>
                'nullable|required_if:has_print,1|integer|min:0|max:1000000',

            'has_print_discount' =>
                'nullable|boolean',

            'print_discount_percent' =>
                'nullable|required_if:has_print_discount,1|numeric|min:0|max:70',

            /*
            |--------------------------------------------------------------
            | E-BOOK
            |--------------------------------------------------------------
            */

            'ebook_isbn' =>
                'nullable|string|max:255',

            'ebook_price' =>
                'nullable|required_if:has_ebook,1|numeric|min:0.01|max:999999999999.99',

            'has_ebook_discount' =>
                'nullable|boolean',

            'ebook_discount_percent' =>
                'nullable|required_if:has_ebook_discount,1|numeric|min:0|max:70',

            /*
            |--------------------------------------------------------------
            | COVER
            |--------------------------------------------------------------
            */

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

            'remove_preview_pdf' =>
                'nullable|boolean',
        ], [
            'title.required' =>
                'Judul buku wajib diisi.',

            'publisher.required' =>
                'Penerbit wajib diisi.',

            'authors.required' =>
                'Minimal satu penulis wajib diisi.',

            'print_price.required_if' =>
                'Harga Buku Cetak wajib diisi.',

            'print_price.numeric' =>
                'Harga Buku Cetak tidak valid.',

            'print_stock.required_if' =>
                'Stok Buku Cetak wajib diisi.',

            'print_stock.integer' =>
                'Stok Buku Cetak harus berupa angka bulat.',

            'ebook_price.required_if' =>
                'Harga E-Book wajib diisi.',

            'ebook_price.numeric' =>
                'Harga E-Book tidak valid.',

            'print_discount_percent.required_if' =>
                'Persentase diskon Buku Cetak wajib diisi.',

            'ebook_discount_percent.required_if' =>
                'Persentase diskon E-Book wajib diisi.',

            'cover.image' =>
                'File cover harus berupa gambar.',

            'cover.mimes' =>
                'Format cover hanya boleh JPG, JPEG, PNG, atau WebP.',

            'cover.max' =>
                'Ukuran file cover maksimal 8 MB.',

            'preview_pdf.mimes' =>
                'Preview buku harus berupa file PDF.',

            'preview_pdf.max' =>
                'Ukuran PDF preview maksimal 50 MB.',

            'publish_year.min' =>
                'Tahun terbit tidak valid.',

            'publish_year.max' =>
                'Tahun terbit tidak boleh lebih dari ' .
                (now()->year + 2) .
                '.',
        ]);
    }

    private function contributorFields(Request $request): array
    {
        $authors = Book::normalizeContributorNames($request->input('authors', []));
        $editors = Book::normalizeContributorNames($request->input('editors', []));

        if ($authors === []) {
            throw ValidationException::withMessages([
                'authors' => 'Minimal satu nama penulis wajib diisi.',
            ]);
        }

        $authorMode = in_array($request->input('author_display_mode'), ['inline', 'stacked', 'primary'], true)
            ? (string) $request->input('author_display_mode')
            : 'inline';
        $editorMode = in_array($request->input('editor_display_mode'), ['inline', 'stacked', 'primary'], true)
            ? (string) $request->input('editor_display_mode')
            : 'inline';

        $primaryAuthor = trim((string) $request->input('primary_author'));
        if ($authorMode !== 'primary' || !in_array($primaryAuthor, $authors, true)) {
            $primaryAuthor = $authorMode === 'primary' ? ($authors[0] ?? null) : null;
        }

        $primaryEditor = trim((string) $request->input('primary_editor'));
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

    /*
    |--------------------------------------------------------------------------
    | STORE COVER
    |--------------------------------------------------------------------------
    */

    private function storeCover(
        UploadedFile $file
    ): string {
        $sourcePath =
            $file->getRealPath();

        if (
            !$sourcePath ||
            !is_file($sourcePath)
        ) {
            throw ValidationException::withMessages([
                'cover' =>
                    'File cover tidak dapat dibaca. Silakan pilih gambar lain.',
            ]);
        }

        $imageInfo =
            @getimagesize(
                $sourcePath
            );

        if (!$imageInfo) {
            throw ValidationException::withMessages([
                'cover' =>
                    'File cover bukan gambar yang valid.',
            ]);
        }

        $width =
            (int) ($imageInfo[0] ?? 0);

        $height =
            (int) ($imageInfo[1] ?? 0);

        if (
            $width < 900 ||
            $height < 1200
        ) {
            throw ValidationException::withMessages([
                'cover' =>
                    "Resolusi cover terlalu kecil ({$width} × {$height} px). " .
                    "Gunakan minimal 900 × 1200 px. " .
                    "Disarankan 1200 × 1600 px agar cover tetap tajam.",
            ]);
        }

        if (
            $width > 10000 ||
            $height > 14000
        ) {
            throw ValidationException::withMessages([
                'cover' =>
                    "Resolusi cover terlalu besar ({$width} × {$height} px). " .
                    "Gunakan maksimal sekitar 10000 × 14000 px.",
            ]);
        }

        $path =
            $file->store(
                'book-covers',
                'public'
            );

        if (!$path) {
            throw ValidationException::withMessages([
                'cover' =>
                    'Cover gagal disimpan. Silakan coba upload kembali.',
            ]);
        }

        return $path;
    }

    /*
    |--------------------------------------------------------------------------
    | DISCOUNT CALCULATION
    |--------------------------------------------------------------------------
    */

    private function calculateDiscount(
        float $price,
        float $percent
    ): float {
        $percent = max(
            0,
            min(
                70,
                $percent
            )
        );

        return round(
            $price -
            ($price * $percent / 100),
            2
        );
    }
}