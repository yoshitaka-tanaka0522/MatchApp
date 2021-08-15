<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show($id)
    {
        //Eloquent(エロクアント)、日本語で雄弁(人を感銘させるような、堂々たる弁舌)という機能を使っている
        //モデルファイル::メソッド名(引数)
        //↓はUserモデル(userテーブル)内に指定のidがあれば取得するという命令
        //↓はuserのデータの中身の例
        //   #attributes: array:11 [▼
        //   "id" => 9
        //   "name" => "田中"
        //   "email" => "tesgggt@test.com"
        //   "email_verified_at" => null
        //   "password" => "$2y$10$/YTjJxLB2jt/RfCM8cpvcuHLKI07mnzZbK4muMqpMY0es7aY/3Akm"
        //   "remember_token" => null
        //   "created_at" => "2021-08-15 22:20:13"
        //   "updated_at" => "2021-08-15 22:20:13"
        //   "self_introduction" => "tst"
        //   "sex" => 0
        //   "img_name" => "EVepduNU0AAF2V8_1629033613.jpg"
        // ]
        $user = User::findorFail($id);
        return view('users.show',compact('user'));
    }
}
