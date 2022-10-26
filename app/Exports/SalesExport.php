<?php

namespace App\Exports;

use App\Models\Sales;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromQuery, WithHeadings
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
            $data = DB::table('sales')
            ->join('users','sales.user_id','=','users.id')
            ->whereBetween('sales.created_at',[ $this->from_date,$this->to_date])
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