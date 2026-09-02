<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookStockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookStockTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'is_admin' => true,
        ]);
    }

    private function book(array $overrides = []): Book
    {
        return Book::create(array_merge([
            'title' => 'Buku Stok Test',
            'slug' => 'buku-stok-test',
            'publisher' => 'Baca Dulu',
            'author' => 'Penulis Test',
            'price' => 100000,
            'has_print' => true,
            'print_price' => 100000,
            'print_stock' => 5,
            'has_ebook' => false,
            'category' => 'Umum',
        ], $overrides));
    }

    public function test_admin_can_add_print_stock_and_history_is_recorded(): void
    {
        $admin = $this->admin();
        $book = $this->book(['print_stock' => 5]);

        $response = $this
            ->actingAs($admin, 'admin')
            ->post(route('admin.books.stock.add', $book->slug), [
                'quantity' => 7,
                'note' => 'Cetak ulang.',
            ]);

        $response->assertRedirect(route('admin.books.edit', $book->slug));

        $this->assertSame(12, (int) $book->fresh()->print_stock);

        $this->assertDatabaseHas('book_stock_movements', [
            'book_id' => $book->id,
            'user_id' => $admin->id,
            'type' => 'restock',
            'quantity_change' => 7,
            'stock_before' => 5,
            'stock_after' => 12,
        ]);
    }

    public function test_confirmed_sale_decreases_stock_and_records_history(): void
    {
        $admin = $this->admin();
        $book = $this->book(['print_stock' => 5]);

        $response = $this
            ->actingAs($admin, 'admin')
            ->post(route('admin.books.stock.sale', $book->slug), [
                'quantity' => 2,
                'note' => 'Order WhatsApp.',
            ]);

        $response->assertRedirect(route('admin.books.edit', $book->slug));

        $this->assertSame(3, (int) $book->fresh()->print_stock);

        $this->assertDatabaseHas('book_stock_movements', [
            'book_id' => $book->id,
            'type' => 'sale',
            'quantity_change' => -2,
            'stock_before' => 5,
            'stock_after' => 3,
        ]);
    }

    public function test_sale_cannot_make_stock_negative(): void
    {
        $admin = $this->admin();
        $book = $this->book(['print_stock' => 2]);

        $response = $this
            ->actingAs($admin, 'admin')
            ->from(route('admin.books.edit', $book->slug))
            ->post(route('admin.books.stock.sale', $book->slug), [
                'quantity' => 3,
            ]);

        $response->assertRedirect(route('admin.books.edit', $book->slug));
        $response->assertSessionHasErrors('quantity');

        $this->assertSame(2, (int) $book->fresh()->print_stock);
        $this->assertSame(0, BookStockMovement::query()->count());
    }

    public function test_bookstore_marks_print_book_as_sold_out_when_stock_is_zero(): void
    {
        $book = $this->book([
            'print_stock' => 0,
            'has_ebook' => true,
            'ebook_price' => 50000,
        ]);

        $response = $this->get(route('portofolio.bookstore'));

        $response->assertOk();
        $response->assertSee('Stok Habis');
        $response->assertSee('E-book');
        $response->assertDontSee('data-key="book-'.$book->id.'-print"', false);
    }

    public function test_creating_print_book_saves_initial_stock_and_history(): void
    {
        $admin = $this->admin();

        $response = $this
            ->actingAs($admin, 'admin')
            ->post(route('admin.books.store'), [
                'title' => 'Buku Baru Dengan Stok',
                'publisher' => 'Baca Dulu',
                'author' => 'Penulis Baru',
                'has_print' => 1,
                'print_price' => 125000,
                'print_stock' => 10,
                'category' => 'Umum',
            ]);

        $response->assertRedirect(route('admin.books.index'));

        $book = Book::query()
            ->where('title', 'Buku Baru Dengan Stok')
            ->firstOrFail();

        $this->assertSame(10, (int) $book->print_stock);

        $this->assertDatabaseHas('book_stock_movements', [
            'book_id' => $book->id,
            'type' => 'initial',
            'quantity_change' => 10,
            'stock_before' => 0,
            'stock_after' => 10,
        ]);
    }
}
