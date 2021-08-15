<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;
use App\Services\CheckExtensionServices;
use App\Services\FileUploadServices;

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

    public function edit($id)
    {
        $user = User::findorFail($id);

        return view('users.edit', compact('user')); 
    }

    //作成したフォームリクエストを適用するためにProfileRequestを受け取る
    public function update($id, ProfileRequest $request)
    {
        $user = User::findorFail($id);
        if(!is_null($request['img_name'])){
            $imageFile = $request['img_name'];
            $list = FileUploadServices::fileUpload($imageFile);
            list($extension, $fileNameToStore, $fileData) = $list;   
            $data_url = CheckExtensionServices::checkExtension($fileData, $extension);
            $image = Image::make($data_url);        
            $image->resize(400,400)->save(storage_path() . '/app/public/images/' . $fileNameToStore );

            $user->img_name = $fileNameToStore;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->sex = $request->sex;
        $user->self_introduction = $request->self_introduction;
        $user->save();
        return redirect('home'); 
    }    
}
