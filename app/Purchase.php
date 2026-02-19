<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Purchase extends Model
{
    public function getUser(){
        return $this->belongsTo('App\User','created_by','id');
    }

    public function getUnit(){
        return $this->belongsTo('App\Unit','unit_id','id');
    }

    public function getCategory(){
        return $this->belongsTo('App\Category','category_id','id');
    }

    public function getPurchase(){
        return $this->belongsTo('App\User','purchase_user_id','id');
    }

    public function getName(){
        return $this->belongsTo('App\Vegetable','vegetable_id','id');
    }

    public function getPurchaseCount(){
        return $this->hasMany('App\Purchase_has_manage','purchase_id','id')->where('created_by', Auth::user()->id);
    }
    public function getPurchaseMin(){
        return $this->hasMany('App\Purchase_has_manage','purchase_id','id');
    }
    public function getPurchaseMinLatest(){
        return $this->hasMany('App\Purchase_has_manage','purchase_id','id')->latest();
    }

    public function getPurchaseOut(){
        return $this->hasMany('App\Purchase_has_out','purchase_id','id');
    }
    
    
    public function getPurchaseMinLatestI(){
        return $this->belongsTo('App\Purchase_has_manage','id','purchase_id')->latest();
    }

}
