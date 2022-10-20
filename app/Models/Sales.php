<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'cash',
        'total_qty',
        'total_amount',
        'discount',
        'user_id'
    ];

    public function scopeFilter($query, array $filter){
        if($filter['search'] ?? false){
            $query->where('total_qty','like', '%'. request('search'). '%')
                    ->orWhere('total_amount', 'like', '%'. request('search'). '%');
        }
    }
}