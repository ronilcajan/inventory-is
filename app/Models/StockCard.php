<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockCard extends Model
{
    use HasFactory;

    protected $table = 'stock_card';

    protected $fillable = [
        'status',
        'quantity',
        'unit',
        'price',
        'reference',
        'mark_up_price',
        'supplier',
        'incharge',
        'balance',
        'products_id'
    ];

    public function scopeFilter($query, array $filter){
        if($filter['date'] ?? false){
            $query->whereMonth('stock_card.created_at', date('n', strtotime($filter['date'])))
                    ->whereYear('.created_at', date('Y', strtotime($filter['date'])));
        }

        if($filter['from'] ?? false){
            $startDate = Carbon::createFromFormat('Y-m-d', request('from'));
            
            if(request('to')){
                $endDate = Carbon::createFromFormat('Y-m-d', request('to'));
                $query->whereBetween('stock_card.created_at',[$startDate,$endDate]);
            }
            $query->where('stock_card.created_at', '>', $startDate);
        }
    } 
}