<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
     protected $fillable = ['name', 'image','category_id'];
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function brand()
    {
        return $this->hasMany('App\Brand');
    }
    public function advertising()
    {
        return $this->hasMany('App\Advertising');
    }
}
