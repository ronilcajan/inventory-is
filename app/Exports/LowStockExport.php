<?php

namespace App\Exports;

use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LowStockExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query(){

        $stocks = Products::select('products.barcode','products.name')
                ->addselect(DB::raw('stock_in.stock_in_qty + stock_out.stock_out_qty as total'))    
                ->addselect('products.unit','stock_out.mark_up','products.min_stocks')
                ->leftJoin('stock_in','stock_in.products_id', '=', 'products.id')
                ->leftJoin('stock_out','stock_out.products_id', '=', 'products.id')
                ->orderBy('products.name','ASC');
        
        return $stocks;
    }

    public function headings(): array{
        return [
            'Barcode',
            'Product Name',
            'Total QTY',
            'Unit',
            'Mark-up Price',
            'Minimum Stocks',
        ];
    }
}