<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Information extends Model
{
    protected $table = 'informations';

    protected $fillable = ['title', 'content', 'image', 'slug'];

    protected static function booted()
    {
        static::saving(function (self $information) {
            if (!$information->slug || $information->isDirty('title')) {
                $information->slug = static::makeSlug($information->title, $information->id ?? null);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
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