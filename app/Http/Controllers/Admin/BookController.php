<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        Book::whereNull('slug')->orWhere('slug', '')->get()->each(function ($book) {
            $book->slug = Book::makeSlug($book->title, $book->id);
            $book->save();
        });

        $books = Book::latest()->get();
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'publisher'        => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'price'            => 'required|numeric|min:0.01|max:999999999999.99',
            'discount_percent' => 'nullable|numeric|min:0|max:70',
            'discounted_price' => 'nullable|numeric|lt:price|min:0.01|max:999999999999.99',
            'has_discount'     => 'sometimes|boolean',
            'category'         => 'nullable|string|max:255',
            'pages'            => 'nullable|integer|min:1',
            'size'             => 'nullable|string|max:255',
            'isbn'             => 'nullable|string|max:255',
            'publish_year'     => 'nullable|integer|min:1900',
            'description'      => 'nullable|string',
            'cover'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('book-covers', 'public');
        }

        $hasDiscount = $request->boolean('has_discount') && $request->filled('discounted_price');

        Book::create([
            'title'               => $request->title,
            'slug'                => Book::makeSlug($request->title),
            'publisher'           => $request->publisher,
            'author'              => $request->author,
            'price'               => $request->price,
            'discount_percent'    => $hasDiscount ? $request->discount_percent : null,
            'discounted_price'    => $hasDiscount ? $request->discounted_price : null,
            'discount_expires_at' => $hasDiscount ? now()->addMonth() : null,
            'cover'               => $coverPath,
            'category'            => $request->category ? trim($request->category) : 'Umum',
            'pages'               => $request->pages,
            'size'                => $request->size,
            'isbn'                => $request->isbn,
            'publish_year'        => $request->publish_year,
            'description'         => $request->description,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'publisher'        => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'price'            => 'required|numeric|min:0.01|max:999999999999.99',
            'discount_percent' => 'nullable|numeric|min:0|max:70',
            'discounted_price' => 'nullable|numeric|lt:price|min:0.01|max:999999999999.99',
            'has_discount'     => 'sometimes|boolean',
            'category'         => 'nullable|string|max:255',
            'pages'            => 'nullable|integer|min:1',
            'size'             => 'nullable|string|max:255',
            'isbn'             => 'nullable|string|max:255',
            'publish_year'     => 'nullable|integer|min:1900',
            'description'      => 'nullable|string',
            'cover'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $book->cover = $request->file('cover')->store('book-covers', 'public');
        }

        $hasDiscount = $request->boolean('has_discount') && $request->filled('discounted_price');

        $book->update([
            'title'               => $request->title,
            'slug'                => Book::makeSlug($request->title, $book->id),
            'publisher'           => $request->publisher,
            'author'              => $request->author,
            'price'               => $request->price,
            'discount_percent'    => $hasDiscount ? $request->discount_percent : null,
            'discounted_price'    => $hasDiscount ? $request->discounted_price : null,
            'discount_expires_at' => $hasDiscount ? now()->addMonth() : null,
            'category'            => $request->category ? trim($request->category) : 'Umum',
            'pages'               => $request->pages,
            'size'                => $request->size,
            'isbn'                => $request->isbn,
            'publish_year'        => $request->publish_year,
            'description'         => $request->description,
            'cover'               => $book->cover,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}