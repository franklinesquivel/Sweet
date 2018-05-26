<?php

namespace Sweet;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'description', 'price', 'status', 'category_id' 
    ];

    public function category()
    {
        return $this->belongsTo('Sweet\Category');
    }

    public function images()
    {
        return $this->hasMany('Sweet\Image');
    }
}
