<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'self_introduction', 'sex', 'img_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //ReactionテーブルUserテーブルの中から、toUserIdとfromUserIdを1つずつ選択することができる
    public function toUserId() 
    {
        //hasMany→usersのテーブルはreactionsテーブルのto_user_id複数に対して働きかけている
        //→複数持っている
        //hasMany(相手のモデル名, 相手モデルのID, 自モデルのID)
        //to_user_id ・・ 表示されているユーザー
        //from_user_id ・・ ログインしているユーザー
        return $this->hasMany('App\Models\Reaction','to_user_id','id');
    }

    public function fromUserId()
    {
        //hasMany→usersのテーブルはreactionsテーブルのfrom_user_id複数に対して働きかけている
        //→複数持っている
       return $this->hasMany('App\Models\Reaction','from_user_id','id');
    }
}
