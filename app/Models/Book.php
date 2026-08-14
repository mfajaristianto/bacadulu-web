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
        'price',
        'discounted_price',
        'discount_expires_at',
        'cover',
        'description',
        'pages',
        'category',
        'size',
        'isbn',
        'publish_year',
    ];

    protected $casts = [
        'discount_expires_at' => 'datetime',
    ];

    // INI WAJIB ADA AGAR ROUTE MENGGUNAKAN SLUG
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::saving(function (self $book) {
            if (!$book->slug || $book->isDirty('title')) {
                $book->slug = static::makeSlug($book->title, $book->id ?? null);
            }
        });
    }

    public function getHasActiveDiscountAttribute()
    {
        return $this->discounted_price && $this->discount_expires_at && $this->discount_expires_at->isFuture();
    }

    public function getEffectivePriceAttribute()
    {
        return $this->has_active_discount ? $this->discounted_price : $this->price;
    }

    public static function makeSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $base = $slug;
        $counter = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}