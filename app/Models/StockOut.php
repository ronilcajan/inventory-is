<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $table = 'stock_out';

    protected $fillable = [
        'percentage',
        'mark_up',
        'incharge',
        'stock_out_qty',
        'products_id',
        'user_id',
    ];
}