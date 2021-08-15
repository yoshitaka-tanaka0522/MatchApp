<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;
use App\Constants\Status;

class MatchingController extends Controller
{
    public static function index() {
        $got_reaction_ids = Reaction::where([
            //自分(to_user_id)へLIKEしてくれた人のIDを取得
            //Reaction::whereは抽出条件
            ['to_user_id', Auth::id()],
            ['status',Status::LIKE]
            // pluckを使うことで、LIKEしてくれた人のID情報のみを取得
        ])->pluck('from_user_id');

        // LIKEしてくれた人の中から、自分がLIKEした人だけを抽出する
        // WhereInを使うことで、LIKEしてくれた人のidだけを検索しつつ、
        // 自分(この場合はfrom_user_id)がLIKEしている人を取得し、
        // 再度IDを取得する  
        $matching_ids = Reaction::whereIn('to_user_id',$got_reaction_ids)
        ->where('status',Status::LIKE)
        ->where('from_user_id',Auth::id())
        // 自分がLikeした人だけを抽出する
        ->pluck('to_user_id');
        $matching_users = User::whereIn('id', $matching_ids)->get();
        $match_users_count = count($matching_users);
        return view('users.index', compact('matching_users', 'match_users_count'));        
    }
}
