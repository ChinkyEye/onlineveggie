<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_no','user_type','type','is_active','branch_id','address_id'
    ];

    protected $guarded = [
        'id','created_by'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','user_type','type'
    ];

    public function setNameAttribute($value){
        return $this->attributes['name'] = strtoupper($value);
    }

    public function getBranch(){
        return $this->belongsTo('App\Branch','branch_id','id');
    }

    public function getAddress(){
        return $this->belongsTo('App\Address','address_id','id');
    }

    public function getUser(){
        return $this->belongsTo('App\User','created_by','id');
    }
}
