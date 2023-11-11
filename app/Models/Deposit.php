<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
     protected $table = "deposits";

     public function client(){
          return $this->belongsTo(Client::class,'client_id','id');
     }

     public function exchange(){
          return $this->belongsTo(Bank::class,'exchange_id','id');
     }

     public function bank(){
          return $this->belongsTo(Bank::class,'bank_id','id');
     }

     public function mode(){
          return $this->belongsTo(Mode::class,'mode_id','id');
     }

     public function branch(){
          return $this->belongsTo(Branch::class,'branch_id','id');
     }
}
