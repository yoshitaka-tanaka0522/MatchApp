<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoomUsers extends Model
{
    //代入できるフィールドを設定する
    //create()メソッドで保存する場合は、
    // 値を代入できるフィールドを指定しておく必要がある
    protected $fillable = ['chat_room_id','user_id'];
    
    public function chatRoom() {
        return $this->belongsTo('App\Models\ChatRoom');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
