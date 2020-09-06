<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $table = 'chatRoom';
     protected $fillable = [
        'to_id', 'from_id'
    ];
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
