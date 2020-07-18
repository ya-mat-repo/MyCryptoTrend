<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'twitter_user_name',    // screen_name
        'twitter_account_name', // name
        'follows_count',        // friends_count
        'followers_count',      // followers_count
        'profile',              // description
        'latest_tweet',         // status->text
    ];

    public function followedUsers()
    {
        return $this->hasMany('App\FollowedUser', 'twitter_user_name');
    }
}
