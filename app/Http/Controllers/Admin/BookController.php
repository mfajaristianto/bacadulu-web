<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
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

        Book::create([

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