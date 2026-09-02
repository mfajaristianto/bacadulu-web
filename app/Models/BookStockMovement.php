<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookStockMovement extends Model
{
    protected $fillable = [
        'book_id',
        'user_id',
        'type',
        'quantity_change',
        'stock_before',
        'stock_after',
        'note',
    ];

    protected $casts = [
        'quantity_change' => 'integer',
        'stock_before' => 'integer',
        'stock_after' => 'integer',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
