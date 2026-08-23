<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookstoreController extends Controller
{
    /**
     * Halaman utama Bookstore.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Kategori aktif
        |--------------------------------------------------------------------------
        */

        $selectedCategory = $request->query(
            'category',
            'Semua'
        );


        /*
        |--------------------------------------------------------------------------
        | Daftar kategori
        |--------------------------------------------------------------------------
        */

        $categories = Book::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');


        /*
        |--------------------------------------------------------------------------
        | Query katalog
        |--------------------------------------------------------------------------
        */

        $booksQuery = Book::query()
            ->latest();


        /*
        |--------------------------------------------------------------------------
        | Filter kategori
        |--------------------------------------------------------------------------
        */

        if (
            $selectedCategory !== 'Semua'
            && $categories->contains($selectedCategory)
        ) {
            $booksQuery->where(
                'category',
                $selectedCategory
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        | Hanya mengambil maksimal 5 buku per halaman.
        |--------------------------------------------------------------------------
        */

        $books = $booksQuery
            ->paginate(5)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Terbitan terbaru
        |--------------------------------------------------------------------------
        */

        $latestBooks = Book::query()
            ->latest()
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Statistik total buku
        |--------------------------------------------------------------------------
        */

        $totalBooks = Book::query()
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Statistik jumlah penerbit
        |--------------------------------------------------------------------------
        */

        $publisherCount = Book::query()
            ->whereNotNull('publisher')
            ->where('publisher', '!=', '')
            ->distinct()
            ->count('publisher');


        /*
        |--------------------------------------------------------------------------
        | Tampilkan Bookstore
        |--------------------------------------------------------------------------
        */

        return view(
            'landing-page.pages.bookstore',
            compact(
                'books',
                'latestBooks',
                'categories',
                'selectedCategory',
                'totalBooks',
                'publisherCount'
            )
        );
    }


    /**
     * Detail buku.
     */
    public function show(Book $book)
    {
        return view(
            'landing-page.pages.book-detail',
            compact('book')
        );
    }
}