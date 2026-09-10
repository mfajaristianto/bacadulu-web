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

    public function index()
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

        $books = Book::latest()->get();

        return view(
            'admin.books.index',
            compact('books')
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
                $coverPath
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

                    'author' =>
                        trim($request->author),

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

            return back()
                ->withErrors(
                    $e->errors()
                )
                ->withInput(
                    $request->except([
                        '_token',
                        'cover',
                    ])
                );
        } catch (Throwable $e) {
            if ($coverPath) {
                Storage::disk('public')
                    ->delete($coverPath);
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
                $coverPath
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

                    'author' =>
                        trim($request->author),

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

            return back()
                ->withErrors(
                    $e->errors()
                )
                ->withInput(
                    $request->except([
                        '_token',
                        '_method',
                        'cover',
                    ])
                );
        } catch (Throwable $e) {
            if ($newCoverPath) {
                Storage::disk('public')
                    ->delete(
                        $newCoverPath
                    );
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
                    ])
                );
        }
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

        DB::transaction(function () use ($book) {
            $book->delete();
        });

        if ($coverPath) {
            Storage::disk('public')
                ->delete(
                    $coverPath
                );
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

            'author' =>
                'required|string|max:255',

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
        ], [
            'title.required' =>
                'Judul buku wajib diisi.',

            'publisher.required' =>
                'Penerbit wajib diisi.',

            'author.required' =>
                'Penulis wajib diisi.',

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

            'publish_year.min' =>
                'Tahun terbit tidak valid.',

            'publish_year.max' =>
                'Tahun terbit tidak boleh lebih dari ' .
                (now()->year + 2) .
                '.',
        ]);
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