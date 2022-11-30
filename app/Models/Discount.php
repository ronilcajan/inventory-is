<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discount';

    protected $fillable = [
        'coupon',
        'discount',
        'use',
        'description',
        'status',
    ];

    public function scopeFilter($query, array $filter){
        if($filter['search'] ?? false){
            $query->where('coupon','like', '%'. request('search'). '%')
                    ->orWhere('description', 'like', '%'. request('search'). '%');
        }
    }
}