<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertising extends Model
{
	protected $table = 'advertisement';
    protected $fillable = [
        'code_number','price','title','image' ,'description','model','user_id','category_id',
        'subCategory_id','brand_id','class_id','country_id','city_id','area_id','phone', 'is_price','is_photos'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
    public function section()
    {
        return $this->belongsTo('App\Section');
    }
    public function images()
    {
        return $this->hasMany('App\Image');
    }
     public function details()
    {
        return $this->hasMany('App\Details');
    }
}
