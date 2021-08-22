<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use App\Models\ChatMessage;
use App\Events\ChatPusher;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    
    public static function show(Request $request){
    
        $matching_user_id = $request->user_id;
        
        // 自分の持っているチャットルームを取得
        $current_user_chat_rooms = ChatRoomUser::where('user_id', Auth::id())
        ->pluck('chat_room_id');

        // 自分の持っているチャットルームからチャット相手のいるルームを探す
        $chat_room_id = ChatRoomUser::whereIn('chat_room_id', $current_user_chat_rooms)
            ->where('user_id', $matching_user_id)
            ->pluck('chat_room_id');


        // なければ作成する
        if ($chat_room_id->isEmpty()){

            ChatRoom::create(); // チャットルーム作成
            
            $latest_chat_room = ChatRoom::orderBy('created_at', 'desc')->first(); // 最新チャットルームを取得

            $chat_room_id = $latest_chat_room->id;

            ChatRoomUser::create( 
            ['chat_room_id' => $chat_room_id,
            'user_id' => Auth::id()]);

            ChatRoomUser::create(
            ['chat_room_id' => $chat_room_id,
            'user_id' => $matching_user_id]);
        }

        if(is_object($chat_room_id)){
            $chat_room_id = $chat_room_id->first();
        }
        
        $chat_room_user = User::findOrFail($matching_user_id);

        $chat_room_user_name = $chat_room_user->name;

        $chat_messages = ChatMessage::where('chat_room_id', $chat_room_id)
        ->orderby('created_at')
        ->get();

        return view('chat.show', 
        compact('chat_room_id', 'chat_room_user',
        'chat_messages','chat_room_user_name'));

    }

    // この行から下を追加します。
    public static function chat(Request $request){

        $chat = new ChatMessage();
        $chat->chat_room_id = $request->chat_room_id;
        $chat->user_id = $request->user_id;
        $chat->message = $request->message;
        $chat->save();

        event(new ChatPusher($chat));
    }
}