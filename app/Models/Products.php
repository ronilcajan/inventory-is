<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'barcode',
        'name',
        'description',
        'unit',
        'min_stocks',
        'category_id'
    ];

    public function scopeFilter($query, array $filter){
        if($filter['search'] ?? false){
            $query->where('products.name','like', '%'. request('search'). '%')
                    ->orWhere('products.barcode',request('search'));
        }
    }

}
