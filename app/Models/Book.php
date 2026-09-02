<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;


    protected $fillable = [

        'title',

        'slug',

        'publisher',

        'author',


        /*
        |--------------------------------------------------------------------------
        | LEGACY PRICE
        |--------------------------------------------------------------------------
        */

        'price',

        'discounted_price',

        'discount_expires_at',


        /*
        |--------------------------------------------------------------------------
        | BUKU CETAK
        |--------------------------------------------------------------------------
        */

        'has_print',

        'print_price',

        'print_stock',

        'print_discount_percent',

        'print_discounted_price',

        'print_discount_expires_at',


        /*
        |--------------------------------------------------------------------------
        | EBOOK
        |--------------------------------------------------------------------------
        */

        'has_ebook',

        'ebook_price',

        'ebook_discount_percent',

        'ebook_discounted_price',

        'ebook_discount_expires_at',


        /*
        |--------------------------------------------------------------------------
        | INFORMASI BUKU
        |--------------------------------------------------------------------------
        */

        'cover',

        'description',

        'pages',

        'category',

        'size',

        'isbn',

        'publish_year',

    ];


    protected $casts = [

        'has_print' =>
            'boolean',

        'has_ebook' =>
            'boolean',


        'price' =>
            'decimal:2',

        'discounted_price' =>
            'decimal:2',

        'discount_expires_at' =>
            'datetime',


        'print_price' =>
            'decimal:2',

        'print_stock' =>
            'integer',

        'print_discount_percent' =>
            'decimal:2',

        'print_discounted_price' =>
            'decimal:2',

        'print_discount_expires_at' =>
            'datetime',


        'ebook_price' =>
            'decimal:2',

        'ebook_discount_percent' =>
            'decimal:2',

        'ebook_discounted_price' =>
            'decimal:2',

        'ebook_discount_expires_at' =>
            'datetime',

    ];


    /*
    |--------------------------------------------------------------------------
    | ROUTE BERDASARKAN SLUG
    |--------------------------------------------------------------------------
    */

    public function getRouteKeyName()
    {
        return 'slug';
    }


    /*
    |--------------------------------------------------------------------------
    | AUTO SLUG
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::saving(function (self $book) {

            if (
                !$book->slug ||
                $book->isDirty('title')
            ) {

                $book->slug =
                    static::makeSlug(

                        $book->title,

                        $book->id ?? null

                    );

            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | DISKON CETAK AKTIF
    |--------------------------------------------------------------------------
    */

    public function getHasActivePrintDiscountAttribute(): bool
    {
        return
            $this->has_print
            &&
            $this->print_discounted_price !== null
            &&
            $this->print_discount_expires_at !== null
            &&
            $this
                ->print_discount_expires_at
                ->isFuture();
    }


    /*
    |--------------------------------------------------------------------------
    | HARGA CETAK AKTIF
    |--------------------------------------------------------------------------
    */

    public function getEffectivePrintPriceAttribute()
    {
        if (!$this->has_print) {

            return null;

        }


        return
            $this->has_active_print_discount

                ? $this->print_discounted_price

                : $this->print_price;
    }


    /*
    |--------------------------------------------------------------------------
    | DISKON EBOOK AKTIF
    |--------------------------------------------------------------------------
    */

    public function getHasActiveEbookDiscountAttribute(): bool
    {
        return
            $this->has_ebook
            &&
            $this->ebook_discounted_price !== null
            &&
            $this->ebook_discount_expires_at !== null
            &&
            $this
                ->ebook_discount_expires_at
                ->isFuture();
    }


    /*
    |--------------------------------------------------------------------------
    | HARGA EBOOK AKTIF
    |--------------------------------------------------------------------------
    */

    public function getEffectiveEbookPriceAttribute()
    {
        if (!$this->has_ebook) {

            return null;

        }


        return
            $this->has_active_ebook_discount

                ? $this->ebook_discounted_price

                : $this->ebook_price;
    }


    /*
    |--------------------------------------------------------------------------
    | STOK BUKU CETAK
    |--------------------------------------------------------------------------
    */

    public function getPrintInStockAttribute(): bool
    {
        return
            $this->has_print
            && (int) $this->print_stock > 0;
    }


    public function stockMovements()
    {
        return $this->hasMany(BookStockMovement::class)
            ->latest();
    }


    /*
    |--------------------------------------------------------------------------
    | LEGACY DISCOUNT
    |--------------------------------------------------------------------------
    */

    public function getHasActiveDiscountAttribute(): bool
    {
        if ($this->has_print) {

            return
                $this->has_active_print_discount;

        }


        if ($this->has_ebook) {

            return
                $this->has_active_ebook_discount;

        }


        return
            $this->discounted_price !== null
            &&
            $this->discount_expires_at !== null
            &&
            $this
                ->discount_expires_at
                ->isFuture();
    }


    /*
    |--------------------------------------------------------------------------
    | LEGACY EFFECTIVE PRICE
    |--------------------------------------------------------------------------
    */

    public function getEffectivePriceAttribute()
    {
        if ($this->has_print) {

            return
                $this->effective_print_price;

        }


        if ($this->has_ebook) {

            return
                $this->effective_ebook_price;

        }


        return
            $this->has_active_discount

                ? $this->discounted_price

                : $this->price;
    }


    /*
    |--------------------------------------------------------------------------
    | SLUG GENERATOR
    |--------------------------------------------------------------------------
    */

    public static function makeSlug(
        string $title,
        ?int $ignoreId = null
    ): string {

        $slug =
            Str::slug($title);


        $base =
            $slug;


        $counter =
            1;


        while (

            static::where(
                'slug',
                $slug
            )
            ->when(

                $ignoreId,

                fn ($query) =>
                    $query->where(
                        'id',
                        '!=',
                        $ignoreId
                    )

            )
            ->exists()

        ) {

            $slug =
                "{$base}-{$counter}";


            $counter++;

        }


        return $slug;
    }
}