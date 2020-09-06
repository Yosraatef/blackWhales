<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourt extends Model
{
	protected $table = 'favorite';
    protected $fillable = [
        'user_id','adv_id'
    ];
}
