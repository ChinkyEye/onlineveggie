<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	protected $fillable = [
        'purchase_id', 'quantity','created_by'
    ];
     public function user(){
        return $this->belongsTo('App\User','created_by','id');
    }
    public function getPurchase(){
        return $this->belongsTo('App\Purchase','purchase_id','id');
    }
    public function getPurchaseHasMin(){
        return $this->belongsTo('App\Purchase_has_manage','purchase_manage_id','id');
    }
}