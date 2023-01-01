<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $fillable = [
        'business_name',
        'system_name',
        'address',
        'contact',
        'email',
        'logo',
        'passcode'
    ];
    
}