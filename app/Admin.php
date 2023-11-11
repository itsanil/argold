<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\AdminMailResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\Access\Authorizable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    protected $guard = 'admin';
    protected $guard_name = 'admin';
    protected $table = "admins";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'branch_id',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roleDetail(){
      return $this->belongsTo(Models\Role::class,'roles','id');
    }

    public function branchDetail(){
          return $this->belongsTo(Models\Branch::class,'branch_id','id');
     }
}
