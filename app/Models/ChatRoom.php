<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    //1つのチャットルームは複数のユーザーが使用する→2人で会話など→複数のユーザを持つ→hasManyのuser
    public function chatRoomUsers() {
        return $this->hasMany('App\Models\ChatRoomUser');
    }

    //1つのチャットルームは複数のメッセージを持つ→hasManyのMessage
    public function chatMessage() {
        return $this->hasMany('App\Models\ChatMessage');
    }
}
