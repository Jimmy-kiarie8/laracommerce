<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
    * Get the products for the brand.
    */
   public function products()
   {
       return $this->hasMany('App\Product', 'category_id');
   }
}
