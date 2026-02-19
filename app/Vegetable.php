<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Vegetable extends Model
{

    public function setDisplayNameAttribute($value){
        return $this->attributes['display_name'] = strtoupper($value);
    }

	public function getCategory(){
        return $this->belongsTo('App\Category','category_id','id');
    }

    public function getVegetableCount(){
    	return $this->hasMany('App\Purchase','vegetable_id','id')->where('created_by', Auth::user()->id);
    }

    public function getVegetableCountAdmin(){
    	return $this->hasMany('App\Purchase','category_id','id');
    }

    public function getUser(){
        return $this->belongsTo('App\User','created_by','id');
    }
}
