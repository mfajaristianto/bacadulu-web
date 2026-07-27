<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'resi_number',
        'user_id',
        'book_title',
        'production_status',
        'delivery_type',
        'delivery_status',
        'driver_lat',
        'driver_lng',
        'driver_name',
        'driver_phone',
    ];
}