<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    	'image'
    ];

    /**
    * Get the brand that owns the product.
    */
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    /**
    * Get the category that owns the product.
    */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
