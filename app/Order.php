<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function getItem(){
        return $this->belongsTo('App\Purchase','purchase_id','id');
    }

    public function getName(){
        return $this->belongsTo('App\Vegetable','vegetable_id','id');
    }

    public function getUser(){
        return $this->belongsTo('App\User','created_by','id');
    }

    public function getUnit(){
        return $this->belongsTo('App\Unit','unit_id','id');
    }

    public function getCalcUnit(){
        return $this->belongsTo('App\Unit','calc_unit_id','id');
    }
}
