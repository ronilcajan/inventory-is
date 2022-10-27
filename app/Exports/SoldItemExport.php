<?php

namespace App\Exports;

use App\Models\Sales;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SoldItemExport implements FromQuery, WithHeadings
{
    use Exportable;
    
    protected $from_date;
    protected $to_date;

    function __construct($from_date,$to_date) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function query(){

        if($this->from_date){

            $data = DB::table('sale_items')
            ->select('sale_items.created_at','sales.id','products.name','sale_items.sale_qty','sale_items.sale_price')
            ->addselect(DB::raw('sale_items.sale_qty * sale_items.sale_price as total'))    
            ->leftJoin('products','products.barcode', '=', 'sale_items.sale_product')
            ->leftJoin('sales','sales.id', '=', 'sale_items.sales_id')
            ->orderBy('sale_items.created_at','DESC')
            ->whereBetween('sale_items.created_at',[ $this->from_date,$this->to_date]);
        }else{
            $data = DB::table('sale_items')
            ->select('sale_items.created_at','sales.id','products.name','sale_items.sale_qty','sale_items.sale_price')
            ->addselect(DB::raw('sale_items.sale_qty * sale_items.sale_price as total'))    
            ->leftJoin('products','products.barcode', '=', 'sale_items.sale_product')
            ->leftJoin('sales','sales.id', '=', 'sale_items.sales_id')
            ->orderBy('sale_items.created_at','DESC');
        }
        return $data;
    }

    public function headings(): array{
        return [
            'Date',
            'Receipt',
            'Item',
            'Quantity',
            'Price',
            'Total Amount',
        ];
    }
}