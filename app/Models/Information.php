<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Information extends Model
{
    protected $table = 'informations';

    protected $fillable = [
        'title',
        'content',
        'image',
        'slug',
        'is_pinned',
        'pinned_at',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'pinned_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Information $information) {
            if (!$information->slug || $information->isDirty('title')) {
                $information->slug = static::makeSlug(
                    $information->title,
                    $information->id
                );
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function makeSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $slug = Str::slug($title);
        $base = $slug ?: 'informasi';
        $slug = $base;
        $counter = 1;

        while (
            static::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}