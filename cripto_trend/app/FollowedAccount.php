<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowedAccount extends Model
{
    protected $fillable = ['email', 'twitter_user_name', 'is_follow_flag', 'user_id', 'candidate_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }
}
