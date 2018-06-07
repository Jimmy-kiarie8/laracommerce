<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcat extends Model
{
    
    /**
     * The users that belong to the role.
     */	
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
