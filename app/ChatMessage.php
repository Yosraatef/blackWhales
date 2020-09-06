<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chatMessages';
     protected $fillable = [
        'from_id', 'to_id','room_id','message','image','type'
    ];
   
}
