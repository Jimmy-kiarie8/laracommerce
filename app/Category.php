<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    /**
     * The roles that belong to the user.
     */
    public function subcats()
    {
        return $this->belongsToMany('App\Subcat');
    }
}