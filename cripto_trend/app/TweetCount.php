<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TweetCount extends Model
{
    protected $fillable = ['currency_code', 'count'];
}
