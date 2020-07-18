<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterAuth extends Model
{
    protected $fillable = [
        'email', 'access_token', 'access_token_secret',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
