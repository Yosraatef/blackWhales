<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	 
     protected $fillable = [
        'name', 'image','normalPrice','specialPrice','vipPrice','normalDays','specialDays','vipDays'
    ];
  	public function subCategories()
    {
        return $this->hasMany('App\SubCategory');
    }
    public function advertising()
    {
        return $this->hasMany('App\Advertising');
    }
}