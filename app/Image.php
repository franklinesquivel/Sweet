<?php

namespace Sweet;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'product_images';
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'image' 
    ];

    public function product()
    {
        return $this->belongsTo('Sweet\Product');
    }
}
