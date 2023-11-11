<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
     protected $table = "clients";

     public function accountType(){
          return $this->belongsTo(AccountType::class,'account_type_id','id');
     }

     public function exchange(){
          return $this->belongsTo(Bank::class,'exchange_id','id');
     }

     public function getTotalWithdrawals(){
          return $this->hasMany(Withdrawal::class,'client_id','id')->where('status',1);
     }

     public function getTotalDeposits(){
          return $this->hasMany(Deposit::class,'client_id','id')->where('status',1);
     }

     public function branch(){
          return $this->belongsTo(Branch::class,'branch_id','id');
     }
}
