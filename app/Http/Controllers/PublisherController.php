<?php

namespace App\Http\Controllers;

use App\Models\Book;

class PublisherController extends Controller
{
    public function index()
    {
        $books = Book::query()
            ->publisherApproved()
            ->orderByDesc('publish_year')
            ->orderByDesc('id')
            ->get();

        return view(
            'landing-page.pages.publisher',
            compact('books')
        );
    }

    public function show(Book $book)
    {
        abort_unless(
            $book->isPublisherApproved(),
            404
        );

        return view(
            'landing-page.pages.publisher-book-detail',
            compact('book')
        );
    }
}
