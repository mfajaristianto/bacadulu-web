<?php

namespace App\Http\Controllers;

use App\Models\Book;

class PublisherController extends Controller
{
    public function index()
    {
        $books = Book::query()
            ->orderByDesc('publish_year')
            ->orderByDesc('id')
            ->get();

        return view(
            'landing-page.pages.publisher',
            compact('books')
        );
    }
}