<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\VendorPayment;

class Vendor extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','bankname',
    'bankaccountno',
    'ifsccode',
    'bankcity',
    'branch',
    ];

    public function payemnts()
    {
        return $this->hasMany(VendorPayment::class);
    }
}
