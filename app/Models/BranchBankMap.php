<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchBankMap extends Model
{
     protected $table = "branch_bank_map";

     public function banks(){
          return $this->belongsTo(Bank::class,'bank_id','id');
     }
}
