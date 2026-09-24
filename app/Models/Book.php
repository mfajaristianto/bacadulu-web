<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_NOT_LISTED = 'not_listed';


    protected $fillable = [

        'title',

        'slug',

        'publisher',

        'author',

        'author_2',

        'author_3',

        'show_authors',

        'author_names',

        'author_display_mode',

        'primary_author',

        'editor',

        'editor_2',

        'editor_3',

        'show_editor',

        'show_editors',

        'editor_names',

        'editor_display_mode',

        'primary_editor',


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

        'print_isbn',

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

        'ebook_isbn',

        'ebook_discount_percent',

        'ebook_discounted_price',

        'ebook_discount_expires_at',


        /*
        |--------------------------------------------------------------------------
        | INFORMASI BUKU
        |--------------------------------------------------------------------------
        */

        'cover',

        'preview_pdf',

        'description',

        'pages',

        'category',

        'size',

        'isbn',

        'publish_year',

        /*
        |--------------------------------------------------------------------------
        | WORKFLOW / API SOURCE
        |--------------------------------------------------------------------------
        */

        'source',
        'external_id',
        'external_cover_url',
        'publisher_status',
        'publisher_review_note',
        'publisher_approved_at',
        'store_status',
        'store_review_note',
        'store_approved_at',
        'last_synced_at',
        'source_updated_at',
        'api_payload',
        'pending_api_payload',
        'has_pending_sync',

    ];


    /*
    |--------------------------------------------------------------------------
    | KONTRIBUTOR BUKU DINAMIS
    |--------------------------------------------------------------------------
    |
    | author/editor legacy tetap dipertahankan untuk kompatibilitas API dan
    | kode lama. Sumber tampilan utama menggunakan author_names/editor_names.
    |
    */

    public static function normalizeContributorNames(mixed $value): array
    {
        $items = is_array($value) ? $value : [$value];
        $names = [];

        foreach ($items as $item) {
            if (!is_string($item) || trim($item) === '') {
                continue;
            }

            // Data lama dari BacaPublisher lazimnya satu string dipisah koma.
            foreach (preg_split('/\s*(?:,|;|\r?\n)\s*/u', trim($item)) ?: [] as $name) {
                $name = trim($name);
                if ($name !== '' && !in_array($name, $names, true)) {
                    $names[] = $name;
                }
            }
        }

        return $names;
    }

    public static function splitContributorString(?string $value): array
    {
        return static::normalizeContributorNames($value);
    }

    public function authors(): array
    {
        $stored = static::normalizeContributorNames($this->author_names ?? []);

        if ($stored !== []) {
            return $stored;
        }

        return static::normalizeContributorNames([
            $this->author,
            $this->author_2,
            $this->author_3,
        ]);
    }

    public function editors(): array
    {
        $stored = static::normalizeContributorNames($this->editor_names ?? []);

        if ($stored !== []) {
            return $stored;
        }

        return static::normalizeContributorNames([
            $this->editor,
            $this->editor_2,
            $this->editor_3,
        ]);
    }

    public function displayedAuthors(): array
    {
        return $this->authors();
    }

    public function displayedEditors(): array
    {
        return $this->editors();
    }

    public function displayedAuthorsText(): string
    {
        return implode(', ', $this->authors());
    }

    public function displayedEditorsText(): string
    {
        return implode(', ', $this->editors());
    }

    public function authorDisplayMode(): string
    {
        return in_array($this->author_display_mode, ['inline', 'stacked', 'primary'], true)
            ? $this->author_display_mode
            : 'inline';
    }

    public function editorDisplayMode(): string
    {
        return in_array($this->editor_display_mode, ['inline', 'stacked', 'primary'], true)
            ? $this->editor_display_mode
            : 'inline';
    }

    public function primaryAuthorName(): ?string
    {
        $authors = $this->authors();
        $primary = trim((string) $this->primary_author);

        return $primary !== '' && in_array($primary, $authors, true)
            ? $primary
            : ($authors[0] ?? null);
    }

    public function primaryEditorName(): ?string
    {
        $editors = $this->editors();
        $primary = trim((string) $this->primary_editor);

        return $primary !== '' && in_array($primary, $editors, true)
            ? $primary
            : ($editors[0] ?? null);
    }

    public function otherAuthors(): array
    {
        $primary = $this->primaryAuthorName();
        return array_values(array_filter($this->authors(), fn ($name) => $name !== $primary));
    }

    public function otherEditors(): array
    {
        $primary = $this->primaryEditorName();
        return array_values(array_filter($this->editors(), fn ($name) => $name !== $primary));
    }

    /*
    |--------------------------------------------------------------------------
    | DESCRIPTION SANITIZER
    |--------------------------------------------------------------------------
    |
    | Deskripsi buku ditampilkan sebagai rich HTML pada halaman detail.
    | Karena itu, HTML dibersihkan saat disimpan dan saat dibaca agar data lama
    | yang belum melalui sanitizer tetap aman ketika dirender dengan {!! !!}.
    |
    */

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => HtmlSanitizer::clean((string) $value),
            set: fn ($value) => HtmlSanitizer::clean((string) $value),
        );
    }


    protected $casts = [

        'has_print' =>
            'boolean',

        'has_ebook' =>
            'boolean',

        'show_authors' =>
            'boolean',

        'author_names' =>
            'array',

        'show_editor' =>
            'boolean',

        'show_editors' =>
            'boolean',

        'editor_names' =>
            'array',


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

        'publisher_approved_at' =>
            'datetime',

        'store_approved_at' =>
            'datetime',

        'last_synced_at' =>
            'datetime',

        'source_updated_at' =>
            'datetime',

        'api_payload' =>
            'array',

        'pending_api_payload' =>
            'array',

        'has_pending_sync' =>
            'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | WORKFLOW STATUS
    |--------------------------------------------------------------------------
    */

    public function scopePublisherApproved($query)
    {
        return $query->where(
            'publisher_status',
            self::STATUS_APPROVED
        );
    }

    public function scopeStoreApproved($query)
    {
        return $query->where(
            'store_status',
            self::STATUS_APPROVED
        );
    }

    public function isPublisherApproved(): bool
    {
        return $this->publisher_status === self::STATUS_APPROVED;
    }

    public function isStoreApproved(): bool
    {
        return $this->store_status === self::STATUS_APPROVED;
    }

    public function getIsExternalSourceAttribute(): bool
    {
        return !empty($this->source) && $this->source !== 'manual';
    }


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
    | ISBN CETAK AKTIF
    |--------------------------------------------------------------------------
    |
    | Data lama hanya memiliki satu kolom ISBN. Fallback ke ISBN lama hanya
    | dilakukan ketika buku memang cuma mempunyai satu format agar ISBN tidak
    | salah ditampilkan pada dua format sekaligus.
    |
    */

    public function getEffectivePrintIsbnAttribute(): ?string
    {
        if (!$this->has_print) {

            return null;

        }


        if (!empty($this->print_isbn)) {

            return $this->print_isbn;

        }


        if (
            !$this->has_ebook &&
            !empty($this->isbn)
        ) {

            return $this->isbn;

        }


        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | ISBN E-BOOK AKTIF
    |--------------------------------------------------------------------------
    */

    public function getEffectiveEbookIsbnAttribute(): ?string
    {
        if (!$this->has_ebook) {

            return null;

        }


        if (!empty($this->ebook_isbn)) {

            return $this->ebook_isbn;

        }


        if (
            !$this->has_print &&
            !empty($this->isbn)
        ) {

            return $this->isbn;

        }


        return null;
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


        if ($slug === '') {

            $slug = 'buku';

        }


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