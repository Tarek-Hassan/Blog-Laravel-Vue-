<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable=['name','price','units','desc','image'];
    
    // public function user(){
    //     return $this->belongsTo('App\User');
    // }

    public function orders(){
        return $this->hasMany('App\Order');
    }
    //
}
