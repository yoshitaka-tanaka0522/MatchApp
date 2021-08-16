<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['chat_room_id','user_id','message'];

    public function ChatRoom() {
        return $this->belongsTo('App\Models\ChatRoom');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }    
}
