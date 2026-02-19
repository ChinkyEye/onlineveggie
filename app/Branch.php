<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function getUser(){
        return $this->belongsTo('App\User','created_by','id');
    }
}
