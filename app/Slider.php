<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    // protected $table = 'users_info';
    protected $fillable = [
        'title','image','created_by','updated_by'
    ];
}
