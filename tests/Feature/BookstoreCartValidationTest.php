<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookstoreCartValidationTest extends TestCase
{
    use RefreshDatabase;

    private function book(array $overrides = []): Book
    {
        return Book::create(array_merge([
            'title' => 'Buku Validasi Keranjang',
            'publisher' => 'Baca Dulu',
            'author' => 'Penulis Test',
            'price' => 100000,
            'has_print' => true,
            'print_price' => 100000,
            'print_stock' => 5,
            'print_isbn' => '978-1-1111-1111-1',
            'has_ebook' => true,
            'ebook_price' => 50000,
            'ebook_isbn' => '978-2-2222-2222-2',
            'category' => 'Umum',
            'size' => '14 x 20 cm',
        ], $overrides));
    }

    public function test_cart_validation_rebuilds_product_from_database(): void
    {
        $book = $this->book();

        $response = $this->postJson(
            route('portofolio.bookstore.cart.validate'),
            [
                'items' => [
                    [
                        'key' => 'book-' . $book->id . '-print',
                        'book_id' => $book->id,
                        'format' => 'print',
                        'qty' => 2,
                        'price' => 1,
                    ],
                ],
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath('ok', false)
            ->assertJsonPath('items.0.title', $book->title)
            ->assertJsonPath('items.0.format', 'Buku Cetak')
            ->assertJsonPath('items.0.price', 100000)
            ->assertJsonPath('items.0.stock', 5)
            ->assertJsonPath('items.0.qty', 2);
    }

    public function test_cart_validation_limits_quantity_to_current_print_stock(): void
    {
        $book = $this->book([
            'print_stock' => 2,
        ]);

        $response = $this->postJson(
            route('portofolio.bookstore.cart.validate'),
            [
                'items' => [
                    [
                        'key' => 'book-' . $book->id . '-print',
                        'book_id' => $book->id,
                        'format' => 'print',
                        'qty' => 5,
                        'price' => 100000,
                    ],
                ],
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath('ok', false)
            ->assertJsonPath('items.0.stock', 2)
            ->assertJsonPath('items.0.qty', 2);
    }

    public function test_cart_validation_accepts_current_ebook_data(): void
    {
        $book = $this->book();

        $response = $this->postJson(
            route('portofolio.bookstore.cart.validate'),
            [
                'items' => [
                    [
                        'key' => 'book-' . $book->id . '-ebook',
                        'book_id' => $book->id,
                        'format' => 'ebook',
                        'qty' => 1,
                        'price' => 50000,
                    ],
                ],
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('items.0.format', 'E-book')
            ->assertJsonPath('items.0.price', 50000)
            ->assertJsonPath('items.0.stock', null);
    }

    public function test_bookstore_hides_books_without_sellable_format(): void
    {
        $visible = $this->book([
            'title' => 'Buku Terlihat',
        ]);

        $hidden = $this->book([
            'title' => 'Buku Tidak Dijual',
            'has_print' => false,
            'print_price' => null,
            'print_stock' => 0,
            'has_ebook' => false,
            'ebook_price' => null,
        ]);

        $response = $this->get(
            route('portofolio.bookstore')
        );

        $response
            ->assertOk()
            ->assertSee($visible->title)
            ->assertDontSee($hidden->title);
    }

    public function test_book_detail_uses_separate_isbn_for_each_format(): void
    {
        $book = $this->book();

        $response = $this->get(
            route(
                'portofolio.bookstore.show',
                $book->slug
            )
        );

        $response
            ->assertOk()
            ->assertSee('ISBN Buku Cetak')
            ->assertSee('978-1-1111-1111-1')
            ->assertSee('ISBN E-Book')
            ->assertSee('978-2-2222-2222-2')
            ->assertSee('Ukuran Buku Cetak')
            ->assertSee('14 x 20 cm');
    }
}
