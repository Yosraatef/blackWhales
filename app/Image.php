<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
     protected $table = 'images';
     protected $fillable = [
        'advertising_id', 'image'
    ];
    public function advertising()
    {
        return $this->belongsTo('App\Advertising');
    }
}
