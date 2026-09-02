<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | FEATURED BOOK
        |--------------------------------------------------------------------------
        |
        | Buku terbaru dijadikan terbitan utama / featured.
        |
        */

        $featuredBook = Book::query()
            ->latest()
            ->first();


        /*
        |--------------------------------------------------------------------------
        | BOOK PORTFOLIO
        |--------------------------------------------------------------------------
        |
        | Featured tidak diulang di daftar buku lainnya.
        |
        */

        $books = Book::query()
            ->when(
                $featuredBook,
                function ($query) use ($featuredBook) {
                    $query->where(
                        'id',
                        '!=',
                        $featuredBook->id
                    );
                }
            )
            ->latest()
            ->paginate(
                8,
                ['*'],
                'books_page'
            )
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | PUBLISHER PARTNERS
        |--------------------------------------------------------------------------
        */

        $publishers = Publisher::query()
            ->latest()
            ->take(6)
            ->get();


        return view(
            'landing-page.pages.publisher',
            compact(
                'featuredBook',
                'books',
                'publishers'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BOOK DETAIL
    |--------------------------------------------------------------------------
    */

    public function show(Book $book)
    {
        return view(
            'landing-page.pages.publisher-book-detail',
            compact('book')
        );
    }
}