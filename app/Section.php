<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	protected $table = 'classes';
    protected $fillable = [
       'name', 'image','brand_id'
    ]; 
  	public function brands()
    {
        return $this->belongsTo('App\Brand');
    }
     public function advertising()
    {
        return $this->hasMany('App\Advertising');
    }
   
}
