<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorPayment extends Model
{
    use HasFactory,SoftDeletes;

protected $fillable = ['vendor_id','payment','date'
    ];

    public function getVendor(){
          return $this->belongsTo(Vendor::class,'vendor_id','id');
     }
}
