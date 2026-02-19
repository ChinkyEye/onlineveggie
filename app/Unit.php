<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function setNameAttribute($value){
   		return $this->attributes['name'] = ucfirst($value);
   }

   public function getUser(){
        return $this->belongsTo('App\User','created_by','id');
    }
}
