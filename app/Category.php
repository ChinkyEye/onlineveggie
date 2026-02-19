<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function setNameAttribute($value){
   		return $this->attributes['name'] = ucfirst($value);
   	}

   public function getUser(){
        return $this->belongsTo('App\User','created_by','id');
    }

    public function getCategoryCount(){
    	return $this->hasMany('App\Purchase','category_id','id');
    }
}
