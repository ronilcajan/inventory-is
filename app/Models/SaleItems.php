<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleItems extends Model
{
    use HasFactory;
    
    protected $table = 'sale_items';
    protected $fillable = [
        'sale_qty',
        'sale_price',
        'sale_product',
        'sales_id'
    ];

    public function scopeFilter($query, array $filter){
        // if($filter['date'] ?? false){
        //     $query->whereMonth('sale_items.created_at', date('n', strtotime($filter['date'])))
        //             ->whereYear('sale_items.created_at', date('Y', strtotime($filter['date'])));
        // }

        if($filter['from'] ?? false){
            $startDate = Carbon::createFromFormat('Y-m-d', request('from'));
            
            if(request('to')){
                $endDate = Carbon::createFromFormat('Y-m-d', request('to'));
                $query->whereBetween('sale_items.created_at',[$startDate,$endDate]);
            }
            $query->where('sale_items.created_at', '>', $startDate);
        }
    } 
}