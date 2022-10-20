<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
    ];

    public function scopeFilter($query, array $filter){
        if($filter['search'] ?? false){
            $query->where('name','like', '%'. request('search'). '%')
                    ->orWhere('description', 'like', '%'. request('search'). '%');
        }
    }
}
