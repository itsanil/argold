<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
     protected $table = "expenses";

     public function branch(){
          return $this->belongsTo(Branch::class,'branch_id','id');
     }

     public function bank(){
          return $this->belongsTo(Bank::class,'bank_id','id');
     }

     public function category(){
          return $this->belongsTo(Category::class,'category_id','id');
     }
}
