<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    protected $table = 'detailsAdv';

     protected $fillable = [
        'value', 'key','advertising_id'
    ];
    public function advertising()
    {
        return $this->belongsTo('App\Advertising');
    }
}
