<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_total extends Model
{
    public function getUser(){
        return $this->belongsTo('App\User','created_by','id');
    }

    public function getCustomerOrder(){
        return $this->belongsTo('App\User','order_by','id');
    }

    public function getCustomer(){
        return $this->belongsTo('App\User','customer_id','id');
    }

    public function orderDetail()
    {
        return $this->hasMany('App\Order','bill_id','bill_id');
    }
}
