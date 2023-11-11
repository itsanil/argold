<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Branch extends Model
{
     protected $table = "branches";

     public function branchBankDetails(){
          return $this->hasManyThrough(Bank::class,BranchBankMap::class,'branch_id','id','id','bank_id')->select('banks.id', 'banks.name','branch_bank_map.opening_balance')->where('branch_bank_map.status',1)->orderBy('account_type_id','desc');
     }

     public function branchBanks(){
          return $this->hasMany(BranchBankMap::class)->where('status',1);
     }

     static function getMultiBranchCheck(){
          $user = Auth::user();
          if($user->hasPermissionTo('multi-branch'))
          {
               return Branch::with(['branchBanks' => function($q) {
                    // $q->where('status',1); 
               }])->where('status',1)->get();
          }else{
               return Branch::with(['branchBanks' => function($q) {
                    // $q->where('status',1); 
               }])->where('status',1)->where('id',$user->branch_id)->get();
          }
     }

     static function checkMultiBranchUser(){
          $user = Auth::user();
          if($user->hasPermissionTo('multi-branch'))
          {
               return 0;
          }else{
               return $user->branch_id;
          }
     }

     static function getMultiBranchData(){
          $user = Auth::user();
          if($user->hasPermissionTo('multi-branch'))
          {
               return Branch::where('status',1)->get();
          }else{
               return Branch::where('id',$user->branch_id)->where('status',1)->get();
          }
     }

     static function getMultiBranchEditData(){
          $user = Auth::user();
          if($user->hasPermissionTo('multi-branch'))
          {
               return Branch::where('status',1)->orWhere('id',$user->branch_id)->get();
          }else{
               return Branch::where('id',$user->branch_id)->where('status',1)->orWhere('id',$user->branch_id)->get();
          }
     }

}
