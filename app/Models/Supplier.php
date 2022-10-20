<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = [
        'supplier_name',
        'supplier_email',
        'supplier_contact_no',
        'supplier_address',
        'supplier_company'
    ];

    public function scopeFilter($query, array $filter){
        if($filter['search'] ?? false){
            $query->where('supplier_name','like', '%'. request('search'). '%')
                    ->orWhere('supplier_email', 'like', '%'. request('search'). '%')
                    ->orWhere('supplier_contact_no', 'like', '%'. request('search'). '%')
                    ->orWhere('supplier_address', 'like', '%'. request('search'). '%')
                    ->orWhere('supplier_company', 'like', '%'. request('search'). '%');
        }
    }
}
