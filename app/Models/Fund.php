<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
     protected $table = "funds";

     public function bank(){
          return $this->belongsTo(Bank::class,'bank_id','id');
     }

     public function branch(){
          return $this->belongsTo(Branch::class,'branch_id','id');
     }

     public function fromBank(){
          return $this->belongsTo(Bank::class,'approved_bank_id','id');
     }
}
