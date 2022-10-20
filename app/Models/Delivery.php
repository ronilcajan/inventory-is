<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'delivery';

    protected $fillable = [
        'delivery_or',
        'order_id',
    ];

    public function scopeFilter($query, array $filter){
        if($filter['search'] ?? false){
            $query->where('delivery_or','like', '%'. request('search'). '%')
                    ->orWhere('order_id', 'like', '%'. request('search'). '%');
        }
    }
}
