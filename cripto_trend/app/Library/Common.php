<?php

namespace App\Library;

use Illuminate\Support\Facades\Crypt;
use App\TwitterAuth;

class Common
{
    public static function getDecryptAccessToken ($email) {
        $access_token = Crypt::decryptString(TwitterAuth::where('email', $email)->value('access_token'));
        return $access_token;
    }

    public static function getDecryptAccessTokenSecret ($email) {
        $access_token_secret = Crypt::decryptString(TwitterAuth::where('email', $email)->value('access_token_secret'));
        return $access_token_secret;
    }
}