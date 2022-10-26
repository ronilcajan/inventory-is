<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        if($filter['from'] ?? false){
            $startDate = Carbon::createFromFormat('Y-m-d', request('from'));
            
            
            if(request('to')){
                $endDate = Carbon::createFromFormat('Y-m-d', request('to'));
                $query->whereBetween('sales.created_at',[$startDate,$endDate]);
            }
            $query->where('sales.created_at', '>', $startDate);
        }
    }
}