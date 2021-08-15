<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reaction;
use App\Constants\Status;
use Illuminate\Support\Facades\Log;

class ReactionController extends Controller
{
    // 流れ
    //home画面でlikeかdislikeが選択されたら、
    // Ajax通信で(画面切り替わりなしで) /api/like にアクセス
    // ルーティングファイルに記載あるReactionsコントローラーのcreateメソッドを呼び出す
    // Reactionsコントローラのcreateメソッドでデータを保存する
    public function create(Request $request) 
    {
        // Log::debug($request);

        $to_user_id = $request->to_user_id;
        $like_status = $request->reaction;
        $from_user_id = $request->from_user_id;

        if($like_status === 'like') {
            $status = Status::LIKE;
        } else {
            $status = Status::DISLIKE;
        }

        //POST通信で渡ってきたto_user_idとfrom_user_idの組み合わせがあるか確認
        $checkReaction = Reaction::where([
            ['to_user_id',$to_user_id],
            ['from_user_id',$from_user_id],
        ])->get();

        if($checkReaction->isEmpty()) {
            //マッチした物同士の組み合わせがなければ新しい組み合わせのマッチングなので
            //to_user_idとfrom_user_Idとstatusを保存する
            $reaction = new Reaction();

            $reaction->to_user_id = $to_user_id;
            $reaction->from_user_id = $from_user_id;
            $reaction->status = $status;
            $reaction->save();
        }
    }
}
