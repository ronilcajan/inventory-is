<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_in';

    protected $fillable = [
        'reference',
        'price',
        'stock_in_qty',
        'products_id',
        'supplier_id',
    ];
}