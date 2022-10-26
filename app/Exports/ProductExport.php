<?php

namespace App\Exports;

use App\Models\Sales;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromQuery, WithHeadings
{
    use Exportable;
    
    protected $search;

    function __construct($search) {
        $this->search = $search;
    }

    public function query(){

        if($this->search){
            $data = DB::table('products')
                    ->leftJoin('stock_in', 'products.id', '=', 'stock_in.products_id')
                    ->leftJoin('stock_out', 'products.id', '=', 'stock_out.products_id')
                    ->leftJoin('supplier', 'stock_in.supplier_id', '=', 'supplier.id')
                    ->select('sales.id','users.username','total_qty','total_amount','discount','cash','sales.created_at')
                    ->orderBy('sales.id');
        }else{
            $data = DB::table('sales')
            ->join('users','sales.user_id','=','users.id')
            ->select('sales.id','users.username','total_qty','total_amount','discount','cash','sales.created_at')
            ->orderBy('sales.id');
        }
        return $data;
    }

    public function headings(): array{
        return [
            'ID',
            'Cashier',
            'Total QTY',
            'Total Amount',
            'Discount Added',
            'Cash Amount',
            'Date'
        ];
    }
}