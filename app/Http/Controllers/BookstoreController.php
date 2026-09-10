<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BookstoreController extends Controller
{
    /**
     * Halaman utama Bookstore.
     */
    public function index(Request $request)
    {
        $selectedCategory = trim(
            (string) $request->query('category', 'Semua')
        );

        $categories = $this->storeBooksQuery()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        if (
            $selectedCategory !== 'Semua' &&
            !$categories->contains($selectedCategory)
        ) {
            $selectedCategory = 'Semua';
        }

        $booksQuery = $this->storeBooksQuery()
            ->latest();

        if ($selectedCategory !== 'Semua') {
            $booksQuery->where('category', $selectedCategory);
        }

        $books = $booksQuery
            ->paginate(5)
            ->withQueryString();

        $latestBooks = $this->storeBooksQuery()
            ->latest()
            ->limit(5)
            ->get();

        $totalBooks = $this->storeBooksQuery()
            ->count();

        $publisherCount = $this->storeBooksQuery()
            ->whereNotNull('publisher')
            ->where('publisher', '!=', '')
            ->distinct()
            ->count('publisher');

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
     * Detail buku Bookstore.
     */
    public function show(Book $book)
    {
        abort_unless(
            $this->bookCanBeSold($book),
            404
        );

        return view(
            'landing-page.pages.book-detail',
            compact('book')
        );
    }

    /**
     * Validasi ulang isi keranjang dengan data server.
     *
     * LocalStorage hanya dipakai sebagai kenyamanan UI. Harga, stok, judul,
     * dan detail produk yang dikirim ke WhatsApp selalu dibangun ulang dari
     * database agar perubahan harga/stok maupun manipulasi LocalStorage tidak
     * ikut dianggap sebagai data transaksi yang valid.
     */
    public function validateCart(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => [
                'required',
                'array',
                'min:1',
                'max:50',
            ],

            'items.*.key' => [
                'required',
                'string',
                'max:255',
            ],

            'items.*.book_id' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.format' => [
                'required',
                'string',
                'in:print,ebook',
            ],

            'items.*.qty' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'items.*.price' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        $bookIds = collect($validated['items'])
            ->pluck('book_id')
            ->unique()
            ->values();

        /** @var Collection<int, Book> $books */
        $books = Book::query()
            ->whereIn('id', $bookIds)
            ->get()
            ->keyBy('id');

        $freshItems = [];
        $issues = [];

        foreach ($validated['items'] as $item) {
            /** @var Book|null $book */
            $book = $books->get((int) $item['book_id']);

            if (!$book) {
                $issues[] = 'Salah satu buku di keranjang sudah tidak tersedia.';
                continue;
            }

            $format = (string) $item['format'];
            $qty = (int) $item['qty'];
            $clientPrice = isset($item['price'])
                ? (float) $item['price']
                : null;

            if ($format === 'print') {
                if (
                    !$book->has_print ||
                    $book->print_price === null
                ) {
                    $issues[] = "Buku Cetak \"{$book->title}\" sudah tidak tersedia.";
                    continue;
                }

                $stock = max(0, (int) $book->print_stock);

                if ($stock < 1) {
                    $issues[] = "Stok Buku Cetak \"{$book->title}\" sudah habis.";
                    continue;
                }

                if ($qty > $stock) {
                    $issues[] = "Stok Buku Cetak \"{$book->title}\" tinggal {$stock} buku.";
                    $qty = $stock;
                }

                $price = (float) $book->effective_print_price;
                $formatLabel = 'Buku Cetak';
            } else {
                if (
                    !$book->has_ebook ||
                    $book->ebook_price === null
                ) {
                    $issues[] = "E-book \"{$book->title}\" sudah tidak tersedia.";
                    continue;
                }

                $stock = null;
                $price = (float) $book->effective_ebook_price;
                $formatLabel = 'E-book';
            }

            if (
                $clientPrice !== null &&
                abs($clientPrice - $price) > 0.009
            ) {
                $issues[] = "Harga {$formatLabel} \"{$book->title}\" telah diperbarui.";
            }

            $freshItems[] = [
                'key' => (string) $item['key'],
                'bookId' => $book->id,
                'title' => $book->title,
                'format' => $formatLabel,
                'author' => $book->author,
                'publisher' => $book->publisher ?: 'Baca Dulu',
                'cover' => $book->cover
                    ? asset('storage/' . $book->cover)
                    : '',
                'description' => Str::limit(
                    strip_tags((string) $book->description),
                    2500
                ),
                'detailUrl' => route(
                    'portofolio.bookstore.show',
                    ['book' => $book->slug]
                ),
                'price' => $price,
                'stock' => $stock,
                'qty' => $qty,
            ];
        }

        $freshItems = collect($freshItems)
            ->unique('key')
            ->values()
            ->all();

        if (!$freshItems) {
            return response()->json([
                'ok' => false,
                'items' => [],
                'issues' => array_values(array_unique($issues)),
                'message' => 'Produk di keranjang sudah tidak tersedia. Silakan pilih buku kembali.',
            ]);
        }

        $issues = array_values(array_unique($issues));

        return response()->json([
            'ok' => count($issues) === 0,
            'items' => $freshItems,
            'issues' => $issues,
            'message' => count($issues)
                ? 'Keranjang diperbarui sesuai harga dan stok terbaru. Silakan periksa kembali sebelum checkout.'
                : 'Keranjang sudah sesuai dengan data terbaru.',
        ]);
    }

    /**
     * Query dasar buku yang memang tersedia untuk Bookstore.
     */
    private function storeBooksQuery()
    {
        return Book::query()
            ->where(function ($query) {
                $query
                    ->where(function ($print) {
                        $print
                            ->where('has_print', true)
                            ->whereNotNull('print_price');
                    })
                    ->orWhere(function ($ebook) {
                        $ebook
                            ->where('has_ebook', true)
                            ->whereNotNull('ebook_price');
                    });
            });
    }

    private function bookCanBeSold(Book $book): bool
    {
        return (
            $book->has_print &&
            $book->print_price !== null
        ) || (
            $book->has_ebook &&
            $book->ebook_price !== null
        );
    }
}
