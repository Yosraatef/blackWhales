<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $table = 'report';
    protected $fillable = [
        'massage', 'user_id','reported_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
