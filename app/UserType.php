<?php

namespace Sweet;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $primaryKey = 'id'; // or null
    public $incrementing = false;
    public $timestamps = false;
    
    protected $table = 'users_types';
    protected $fillable = ['id', 'name', 'description'];
    
    public function users()
    {
        $this->hasMany('Sweet\User');
    }
}
