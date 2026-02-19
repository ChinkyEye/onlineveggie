<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_has_manage extends Model
{
    public function getUnit(){
        return $this->belongsTo('App\Unit','unit_id','id');
    }

    public function getPurchase(){
        return $this->belongsTo('App\Purchase','purchase_id','id');
    }
}
