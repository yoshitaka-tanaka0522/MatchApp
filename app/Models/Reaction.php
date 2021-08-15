<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    //Laravelでは初期設定で自動的にインクリメントIDと更新日時が作成されるが
    //Reactionモデルでは不要のため無効化
    public $incrementing = false;
    public $timestamps = false;

    //Relation
    public function toUserId() {
        //Userテーブルのto_user_idを複数受け取る
        return $this->belongsTo('App\Models/User','to_user_id','id');
    }

    public function fromUserId() {
        //Userテーブルのto_user_idを複数受け取る
        return $this->belongsTo('App\Models/User','from_user_id','id');
    }
}
