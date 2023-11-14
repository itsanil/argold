<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeeSalary;

class Employee extends Model
{
    use HasFactory;

    public function getSalary()
    {
        return $this->hasMany(EmployeeSalary::class);
    }
}
