<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //今ログインしているユーザーのメールアドレスを取得する
        $myEmail = Auth::user()->email;
        return [
            'name' => 'required|string|max:255',
            'email' => ['required','string','email','max:255',
            //ユニークなメールアドレスがすでに登録されている状態のため
            //登録済みの自分のメールアドレスはチェック対象外にする必要がある
            //↓はユーザー情報のメールアドレスがユニークであるか確認している
            //ログイン済みユーザーのメールアドレスは除外している
            Rule::unique('users','email')->whereNot('email',$myEmail)],
        ];
    }
}
