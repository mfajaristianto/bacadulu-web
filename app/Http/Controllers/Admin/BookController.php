<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // 1. Menampilkan daftar buku di panel admin
    public function index()
    {
        $books = Book::latest()->get();
        return view('admin.books.index', compact('books'));
    }

    // 2. Menampilkan form tambah buku
    public function create()
    {
        return view('admin.books.create');
    }

    // 3. Menyimpan data buku baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'publisher'      => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'price'          => 'required|numeric',
            'original_price' => 'nullable|numeric',
            'rating'         => 'nullable|string',
            'category'       => 'nullable|string|max:255',
            'pages'          => 'nullable|integer|min:1',
            'description'    => 'nullable|string',
            'cover'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload foto cover buku
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('book-covers', 'public');
        }

        Book::create([
            'title'          => $request->title,
            'publisher'      => $request->publisher,
            'author'         => $request->author,
            'price'          => $request->price,
            'original_price' => $request->original_price,
            'rating'         => $request->rating ?? '5.0',
            'cover'          => $coverPath,
            'category'       => $request->category,
            'pages'          => $request->pages,
            'description'    => $request->description,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    // 4. Menampilkan form edit buku
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    // 5. Memperbarui data buku
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'publisher'      => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'price'          => 'required|numeric',
            'original_price' => 'nullable|numeric',
            'rating'         => 'nullable|string',
            'category'       => 'nullable|string|max:255',
            'pages'          => 'nullable|integer|min:1',
            'description'    => 'nullable|string',
            'cover'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $book->cover = $request->file('cover')->store('book-covers', 'public');
        }

        $book->update([
            'title'          => $request->title,
            'publisher'      => $request->publisher,
            'author'         => $request->author,
            'price'          => $request->price,
            'original_price' => $request->original_price,
            'rating'         => $request->rating ?? '5.0',
            'category'       => $request->category,
            'pages'          => $request->pages,
            'description'    => $request->description,
            'cover'          => $book->cover,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    // 6. Menghapus buku
    public function destroy(Book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}