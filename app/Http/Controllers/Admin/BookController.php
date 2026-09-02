<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | PERBAIKI SLUG DATA LAMA
        |--------------------------------------------------------------------------
        */

        Book::query()
            ->where(function ($query) {

                $query
                    ->whereNull('slug')
                    ->orWhere('slug', '');

            })
            ->get()
            ->each(function ($book) {

                $book->slug =
                    Book::makeSlug(
                        $book->title,
                        $book->id
                    );

                $book->save();

            });


        $books =
            Book::latest()
                ->get();


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
        return view(
            'admin.books.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ) {

        $this->validateBook(
            $request
        );


        /*
        |--------------------------------------------------------------------------
        | FORMAT
        |--------------------------------------------------------------------------
        */

        $hasPrint =
            $request->boolean(
                'has_print'
            );


        $hasEbook =
            $request->boolean(
                'has_ebook'
            );


        /*
        |--------------------------------------------------------------------------
        | MINIMAL SATU FORMAT
        |--------------------------------------------------------------------------
        */

        if (
            !$hasPrint &&
            !$hasEbook
        ) {

            throw ValidationException::withMessages([

                'book_format' =>
                    'Pilih minimal satu format buku: Buku Cetak atau E-book.'

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CETAK
        |--------------------------------------------------------------------------
        */

        $printPrice =
            $hasPrint
                ? (float) $request->print_price
                : null;


        $printStock =
            $hasPrint
                ? (int) $request->print_stock
                : 0;


        $hasPrintDiscount =
            $hasPrint
            &&
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
        | EBOOK
        |--------------------------------------------------------------------------
        */

        $ebookPrice =
            $hasEbook
                ? (float) $request->ebook_price
                : null;


        $hasEbookDiscount =
            $hasEbook
            &&
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
        |
        | Field price lama tidak boleh kosong.
        |
        | Jika Cetak tersedia:
        | gunakan harga Cetak.
        |
        | Jika hanya E-book:
        | gunakan harga E-book.
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
        | COVER
        |--------------------------------------------------------------------------
        */

        $coverPath =
            null;


        if (
            $request->hasFile(
                'cover'
            )
        ) {

            $coverPath =
                $request
                    ->file('cover')
                    ->store(
                        'book-covers',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        $book = Book::create([

            /*
            |--------------------------------------------------------------------------
            | BASIC DATA
            |--------------------------------------------------------------------------
            */

            'title' =>
                $request->title,

            'slug' =>
                Book::makeSlug(
                    $request->title
                ),

            'publisher' =>
                $request->publisher,

            'author' =>
                $request->author,


            /*
            |--------------------------------------------------------------------------
            | LEGACY PRICE
            |--------------------------------------------------------------------------
            */

            'price' =>
                $legacyPrice,

            'discounted_price' =>
                $legacyDiscountedPrice,

            'discount_expires_at' =>
                $legacyDiscountExpiresAt,


            /*
            |--------------------------------------------------------------------------
            | CETAK
            |--------------------------------------------------------------------------
            */

            'has_print' =>
                $hasPrint,

            'print_price' =>
                $printPrice,

            'print_stock' =>
                $printStock,

            'print_discount_percent' =>
                $printDiscountPercent,

            'print_discounted_price' =>
                $printDiscountedPrice,

            'print_discount_expires_at' =>
                $printDiscountExpiresAt,


            /*
            |--------------------------------------------------------------------------
            | EBOOK
            |--------------------------------------------------------------------------
            */

            'has_ebook' =>
                $hasEbook,

            'ebook_price' =>
                $ebookPrice,

            'ebook_discount_percent' =>
                $ebookDiscountPercent,

            'ebook_discounted_price' =>
                $ebookDiscountedPrice,

            'ebook_discount_expires_at' =>
                $ebookDiscountExpiresAt,


            /*
            |--------------------------------------------------------------------------
            | DETAIL
            |--------------------------------------------------------------------------
            */

            'cover' =>
                $coverPath,

            'category' =>
                $request->filled('category')
                    ? trim(
                        $request->category
                    )
                    : 'Umum',

            'pages' =>
                $request->pages,

            'size' =>
                $request->size,

            'isbn' =>
                $request->isbn,

            'publish_year' =>
                $request->publish_year,

            'description' =>
                $request->description,

        ]);


        if ($hasPrint && $printStock > 0) {

            $book->stockMovements()->create([
                'user_id' => auth('admin')->id(),
                'type' => 'initial',
                'quantity_change' => $printStock,
                'stock_before' => 0,
                'stock_after' => $printStock,
                'note' => 'Stok awal saat buku dibuat.',
            ]);
        }


        return redirect()
            ->route(
                'admin.books.index'
            )
            ->with(
                'success',
                'Buku berhasil ditambahkan!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        Book $book
    ) {

        $book->load([
            'stockMovements.user',
        ]);


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

        $this->validateBook(
            $request
        );


        /*
        |--------------------------------------------------------------------------
        | FORMAT
        |--------------------------------------------------------------------------
        */

        $hasPrint =
            $request->boolean(
                'has_print'
            );


        $hasEbook =
            $request->boolean(
                'has_ebook'
            );


        if (
            !$hasPrint &&
            !$hasEbook
        ) {

            throw ValidationException::withMessages([

                'book_format' =>
                    'Pilih minimal satu format buku: Buku Cetak atau E-book.'

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CETAK
        |--------------------------------------------------------------------------
        */

        $printPrice =
            $hasPrint
                ? (float) $request->print_price
                : null;


        $oldPrintStock =
            (int) $book->print_stock;


        $printStock =
            $hasPrint
                ? (int) $request->print_stock
                : 0;


        $hasPrintDiscount =
            $hasPrint
            &&
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
        | EBOOK
        |--------------------------------------------------------------------------
        */

        $ebookPrice =
            $hasEbook
                ? (float) $request->ebook_price
                : null;


        $hasEbookDiscount =
            $hasEbook
            &&
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
        | LEGACY
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
        | COVER
        |--------------------------------------------------------------------------
        */

        $coverPath =
            $book->cover;


        if (
            $request->hasFile(
                'cover'
            )
        ) {

            if ($book->cover) {

                Storage::disk(
                    'public'
                )->delete(
                    $book->cover
                );
            }


            $coverPath =
                $request
                    ->file('cover')
                    ->store(
                        'book-covers',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $book->update([

            'title' =>
                $request->title,

            'slug' =>
                Book::makeSlug(
                    $request->title,
                    $book->id
                ),

            'publisher' =>
                $request->publisher,

            'author' =>
                $request->author,


            /*
            |--------------------------------------------------------------------------
            | LEGACY
            |--------------------------------------------------------------------------
            */

            'price' =>
                $legacyPrice,

            'discounted_price' =>
                $legacyDiscountedPrice,

            'discount_expires_at' =>
                $legacyDiscountExpiresAt,


            /*
            |--------------------------------------------------------------------------
            | CETAK
            |--------------------------------------------------------------------------
            */

            'has_print' =>
                $hasPrint,

            'print_price' =>
                $printPrice,

            'print_stock' =>
                $printStock,

            'print_discount_percent' =>
                $printDiscountPercent,

            'print_discounted_price' =>
                $printDiscountedPrice,

            'print_discount_expires_at' =>
                $printDiscountExpiresAt,


            /*
            |--------------------------------------------------------------------------
            | EBOOK
            |--------------------------------------------------------------------------
            */

            'has_ebook' =>
                $hasEbook,

            'ebook_price' =>
                $ebookPrice,

            'ebook_discount_percent' =>
                $ebookDiscountPercent,

            'ebook_discounted_price' =>
                $ebookDiscountedPrice,

            'ebook_discount_expires_at' =>
                $ebookDiscountExpiresAt,


            /*
            |--------------------------------------------------------------------------
            | DETAIL
            |--------------------------------------------------------------------------
            */

            'category' =>
                $request->filled('category')
                    ? trim(
                        $request->category
                    )
                    : 'Umum',

            'pages' =>
                $request->pages,

            'size' =>
                $request->size,

            'isbn' =>
                $request->isbn,

            'publish_year' =>
                $request->publish_year,

            'description' =>
                $request->description,

            'cover' =>
                $coverPath,

        ]);


        if ($oldPrintStock !== $printStock) {

            $book->stockMovements()->create([
                'user_id' => auth('admin')->id(),
                'type' => 'adjustment',
                'quantity_change' => $printStock - $oldPrintStock,
                'stock_before' => $oldPrintStock,
                'stock_after' => $printStock,
                'note' => 'Penyesuaian stok melalui form edit buku.',
            ]);
        }


        return redirect()
            ->route(
                'admin.books.index'
            )
            ->with(
                'success',
                'Buku berhasil diperbarui!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH STOK BUKU CETAK
    |--------------------------------------------------------------------------
    */

    public function addStock(
        Request $request,
        Book $book
    ) {

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:1000000',
            'note' => 'nullable|string|max:500',
        ]);


        DB::transaction(function () use ($book, $validated) {

            $lockedBook = Book::query()
                ->whereKey($book->id)
                ->lockForUpdate()
                ->firstOrFail();


            if (!$lockedBook->has_print) {
                throw ValidationException::withMessages([
                    'quantity' => 'Buku ini tidak memiliki format Buku Cetak.',
                ]);
            }


            $before =
                (int) $lockedBook->print_stock;

            $after =
                $before + (int) $validated['quantity'];


            $lockedBook->update([
                'print_stock' => $after,
            ]);


            $lockedBook->stockMovements()->create([
                'user_id' => auth('admin')->id(),
                'type' => 'restock',
                'quantity_change' => (int) $validated['quantity'],
                'stock_before' => $before,
                'stock_after' => $after,
                'note' => $validated['note'] ?? 'Penambahan stok Buku Cetak.',
            ]);
        });


        return redirect()
            ->route('admin.books.edit', $book->slug)
            ->with('success', 'Stok Buku Cetak berhasil ditambahkan.');
    }


    /*
    |--------------------------------------------------------------------------
    | CATAT PENJUALAN BUKU CETAK
    |--------------------------------------------------------------------------
    |
    | Dipakai setelah CS mengonfirmasi penjualan/pembayaran.
    | Klik checkout WhatsApp TIDAK mengurangi stok.
    |
    */

    public function recordSale(
        Request $request,
        Book $book
    ) {

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:1000000',
            'note' => 'nullable|string|max:500',
        ]);


        DB::transaction(function () use ($book, $validated) {

            $lockedBook = Book::query()
                ->whereKey($book->id)
                ->lockForUpdate()
                ->firstOrFail();


            if (!$lockedBook->has_print) {
                throw ValidationException::withMessages([
                    'quantity' => 'Buku ini tidak memiliki format Buku Cetak.',
                ]);
            }


            $before =
                (int) $lockedBook->print_stock;

            $quantity =
                (int) $validated['quantity'];


            if ($quantity > $before) {
                throw ValidationException::withMessages([
                    'quantity' => "Jumlah penjualan melebihi stok yang tersedia ({$before} buku).",
                ]);
            }


            $after =
                $before - $quantity;


            $lockedBook->update([
                'print_stock' => $after,
            ]);


            $lockedBook->stockMovements()->create([
                'user_id' => auth('admin')->id(),
                'type' => 'sale',
                'quantity_change' => -$quantity,
                'stock_before' => $before,
                'stock_after' => $after,
                'note' => $validated['note'] ?? 'Penjualan Buku Cetak dikonfirmasi CS.',
            ]);
        });


        return redirect()
            ->route('admin.books.edit', $book->slug)
            ->with('success', 'Penjualan berhasil dicatat dan stok otomatis berkurang.');
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Book $book
    ) {

        if ($book->cover) {

            Storage::disk(
                'public'
            )->delete(
                $book->cover
            );
        }


        $book->delete();


        return redirect()
            ->route(
                'admin.books.index'
            )
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

            'title' =>
                'required|string|max:255',

            'publisher' =>
                'required|string|max:255',

            'author' =>
                'required|string|max:255',


            /*
            |--------------------------------------------------------------------------
            | FORMAT
            |--------------------------------------------------------------------------
            */

            'has_print' =>
                'nullable|boolean',

            'has_ebook' =>
                'nullable|boolean',


            /*
            |--------------------------------------------------------------------------
            | CETAK
            |--------------------------------------------------------------------------
            */

            'print_price' =>
                'nullable|required_if:has_print,1|numeric|min:0.01|max:999999999999.99',

            'print_stock' =>
                'nullable|required_if:has_print,1|integer|min:0|max:1000000',

            'has_print_discount' =>
                'nullable|boolean',

            'print_discount_percent' =>
                'nullable|required_if:has_print_discount,1|numeric|min:0|max:70',


            /*
            |--------------------------------------------------------------------------
            | EBOOK
            |--------------------------------------------------------------------------
            */

            'ebook_price' =>
                'nullable|required_if:has_ebook,1|numeric|min:0.01|max:999999999999.99',

            'has_ebook_discount' =>
                'nullable|boolean',

            'ebook_discount_percent' =>
                'nullable|required_if:has_ebook_discount,1|numeric|min:0|max:70',


            /*
            |--------------------------------------------------------------------------
            | DETAIL
            |--------------------------------------------------------------------------
            */

            'category' =>
                'nullable|string|max:255',

            'pages' =>
                'nullable|integer|min:1',

            'size' =>
                'nullable|string|max:255',

            'isbn' =>
                'nullable|string|max:255',

            'publish_year' =>
                'nullable|integer|min:1900|max:' .
                (now()->year + 2),

            'description' =>
                'nullable|string',

            'cover' =>
                'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CALCULATE DISCOUNT
    |--------------------------------------------------------------------------
    */

    private function calculateDiscount(
        float $price,
        float $percent
    ): float {

        $percent =
            max(
                0,
                min(
                    70,
                    $percent
                )
            );


        return round(

            $price -
            (
                $price *
                $percent /
                100
            ),

            2
        );
    }
}