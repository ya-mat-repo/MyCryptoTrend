<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowedUser extends Model
{
    protected $fillable = ['email', 'twitter_user_name', 'is_follow_flag'];

    // 主キーがidではないため、主キーの規約をオーバーライド
    protected $primaryKey = ['email', 'twitter_user_name'];

    // 主キーを自動増分させないための設定
    public $incrementing = false;

    // 主キーが整数でない場合の設定
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo('App\User', 'email');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Candidate', 'twitter_user_name');
    }
}
