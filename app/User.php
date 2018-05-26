<?php

namespace Sweet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AutorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements
    AutorizableContract, CanResetPasswordContract
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'dui', 'name', 'lastname', 'email', 'birthdate', 'address', 'phone', 'user_type_id', 'age'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userType()
    {
        return $this->belongsTo('Sweet\UserType');
    }

    public function isAdmin()
    {
        return $this->userType->id == 'ADM';
    }
    
    public function isClient()
    {
        return $this->userType->id == 'CLE';
    }
}
