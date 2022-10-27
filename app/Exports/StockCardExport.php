<?php

namespace App\Exports;

use App\Models\Sales;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockCardExport implements FromQuery, WithHeadings
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
            $data = DB::table('stock_card')
            ->select('stock_card.created_at','products.name','status','stock_card.quantity','stock_card.price')
            ->addselect(DB::raw('stock_card.quantity * stock_card.price as total'))
            ->addselect('reference','supplier.supplier_name','stock_card.mark_up_price','stock_card.incharge','stock_card.balance')            
            ->leftJoin('supplier','stock_card.supplier', '=', 'supplier.id')
            ->leftJoin('products','stock_card.products_id', '=', 'products.id')
            ->orderBy('stock_card.created_at','ASC')
            ->whereBetween('stock_card.created_at',[ $this->from_date,$this->to_date]);
            
        }else{
            $data = DB::table('stock_card')
            ->select('stock_card.created_at','products.name','status','stock_card.quantity','stock_card.price')
            ->addselect(DB::raw('stock_card.quantity * stock_card.price as total'))
            ->addselect('reference','supplier.supplier_name','stock_card.mark_up_price','stock_card.incharge','stock_card.balance')
            ->leftJoin('supplier','stock_card.supplier', '=', 'supplier.id')
            ->leftJoin('products','stock_card.products_id', '=', 'products.id')
            ->orderBy('stock_card.created_at','ASC');
        }
        return $data;
    }

    public function headings(): array{
        return [
            'Date',
            'Item',
            'Status',
            'Quantity',
            'Unit Cost',
            'Total Cost',
            'Reference',
            'Supplier',
            'Price',
            'Incharge',
            'Balance'
        ];
    }
}