<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = [
        'name', 'image','subCategory_id'
    ];
  
    public function subCategory()
    {
        return $this->belongsTo('App\SubCategory');
    }
    public function advertising()
    {
        return $this->hasMany('App\Advertising');
    }
    public function section()
    {
        return $this->hasMany('App\Section');
    }
}
