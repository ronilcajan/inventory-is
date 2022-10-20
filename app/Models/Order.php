<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    protected $fillable = [
        'order_number',
        'quantity',
        'amount',
        'status',
        'supplier_id',
    ];

    public function scopeFilter($query, array $filter){
        if($filter['search'] ?? false){
            $query->where('order_number','like', '%'. request('search'). '%')
                    ->orWhere('status', 'like', '%'. request('search'). '%');
        }
    }
}
