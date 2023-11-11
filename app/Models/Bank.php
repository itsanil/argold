<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Expense;
use App\Models\Deposit;

class Bank extends Model
{
     protected $table = "banks";

     public function accountType(){
          return $this->belongsTo(AccountType::class,'account_type_id','id');
     }

     public function branchBanks(){
          return $this->hasMany(BranchBankMap::class)->where('status',1);
     }

     public function branchExpenses(){
          $amount = Expense::where('branch_id',$this->branch_id)->where('bank_id',$this->id)->get()->sum('amount');
          return $amount;
     }

     public function branchBankHasOne(){
          return $this->hasOne(BranchBankMap::class)->where('status',1);
     }

     public function branch(){
          return $this->belongsTo(Branch::class,'branch_id','id');
     }

     public function bonus($branch_id){
          $bonus = 0;
          $deposit_data = Deposit::where('branch_id',$branch_id)->where('exchange_id',$this->id)->where('status',1)->get();
          foreach ($deposit_data as $key => $deposit) {
              $bonus += intval($deposit->amount*$deposit->bonus_percent/100);
          }
          return $bonus;
     }
}
