<?php

namespace Sweet;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    protected $fillable = [
        'name', 'description' 
    ];

    public function products()
    {
        return $this->hasMany('Sweet\Product');
    }
}
