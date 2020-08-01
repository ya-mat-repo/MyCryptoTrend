<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Candidate;
use App\FollowedAccount;
use App\TwitterAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Library\Common;

class AccountListController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ツイッターアカウント一覧表示用のコントローラー
    |--------------------------------------------------------------------------
    */

    /**
     * フォロー対象候補のユーザーを表示する
     */
    public function list()
    {
        $perPage = 10; // 1ページあたりの表示数
        $email = Auth::user()->email;

        // Twitter認証が済んでいるかチェック
        $is_twitter_auth = (empty(TwitterAuth::where('email', $email)->first())) ? false : true;
        Log::debug('$is_twitter_auth = ' . $is_twitter_auth);

        if ($is_twitter_auth) {
            $followed_this_user = DB::table('followed_accounts')
                                    ->select('id', 'twitter_user_name', 'is_follow_flag')
                                    ->where('email', $email);
            $candidates = DB::table('candidates')
                            ->leftJoinSub($followed_this_user, 'followed_this_user', function ($join) {
                                $join->on('candidates.twitter_user_name', '=', 'followed_this_user.twitter_user_name');
                            })->select('candidates.*','followed_this_user.id' , 'followed_this_user.is_follow_flag')
                                ->orderBy('candidates.followers_count', 'DESC')
                                ->paginate($perPage);
        } else {
            $candidates = DB::table('candidates')->orderBy('candidates.followers_count', 'DESC')->paginate($perPage);
        }

        $is_auto_follow = Auth::user()->is_auto_follow;
        Log::debug('>>> $is_auto_follow = ' . $is_auto_follow);
        return view('list', compact('candidates', 'is_twitter_auth', 'is_auto_follow'));
    }

    /**
    * アカウント一覧からフォローするを実行したアカウントをフォローする
    */
    public function followAccount(Request $request)
    {
        $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
        $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';

        $user_id = Auth::user()->id;
        $email = Auth::user()->email;
        $access_token = base64_decode(TwitterAuth::where('email', $email)->value('access_token'));
        $access_token_secret = base64_decode(TwitterAuth::where('email', $email)->value('access_token_secret'));
        // $access_token = Crypt::decryptString(TwitterAuth::where('email', $email)->value('access_token'));
        // $access_token_secret = Crypt::decryptString(TwitterAuth::where('email', $email)->value('access_token_secret'));
        // $access_token = decrypt(TwitterAuth::where('email', $email)->value('access_token'));
        // $access_token_secret = decrypt(TwitterAuth::where('email', $email)->value('access_token_secret'));
        Log::debug('===== $access_token = ' . $access_token);
        Log::debug('===== $access_token_secret = ' . $access_token_secret);
        Log::debug('===== Config::get(app.key) = ' . \Config::get('app.key'));

        // ==============================
        // フォロー対象のアカウント情報を取得
        // ==============================
        $target_account = $request->targetAccount;
        $candidate_id = Candidate::where('twitter_user_name', $target_account)->value('id');
        Log::debug('target_account = ' . $target_account);

        // ==============================
        // 指定したユーザーをフォローする
        // ==============================
        $connect = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
        $do_follow = $connect->post(
            'friendships/create',
            [
                'screen_name' => $target_account,
            ],
        );

        // ======================================
        // ユーザーごとのフォロー状況をテーブルに格納する
        // ======================================
        $target_id = $request->targetId;
        Log::debug('$targetId = ' . $target_id);
        $followed_user = FollowedAccount::where('id', $target_id)->first();
        $flash_message = 'ユーザー [' . $target_account . '] をフォローしました。';
        if (empty($followed_user)) {
            Log::debug('ユーザー [' . $target_account . '] をフォローします。[新規]');
            FollowedAccount::create([
                'email' => $email,
                'twitter_user_name' => $target_account,
                'is_follow_flag' => true,
                'user_id' => $user_id,
                'candidate_id' => $candidate_id,
            ]);
        } else {
            Log::debug('ユーザー [' . $target_account . '] をフォローします。[更新]');
            $followed_user->update(['is_follow_flag' => true]);
        }

        return back()->with(compact('flash_message'));
    }

    /**
    * アカウント一覧からフォロー解除を実行したアカウントをアンフォローする
    */
    public function unfollowAccount(Request $request)
    {
        $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
        $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';

        $email = Auth::user()->email;
        $access_token = base64_decode(TwitterAuth::where('email', $email)->value('access_token'));
        $access_token_secret = base64_decode(TwitterAuth::where('email', $email)->value('access_token_secret'));
        
        // ==============================
        // アンフォロー対象のアカウント情報を取得
        // ==============================
        $target_id = $request->targetId;
        $target_account = $request->targetAccount;
        Log::debug('$target_id = ' . $target_id);
        Log::debug('$target_account = ' . $target_account);

        // ==============================
        // 指定したユーザーをアンフォローする
        // ==============================
        $connect = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
        $doUnfollow = $connect->post(
            'friendships/destroy',
            [
                'screen_name' => $target_account,
            ],
        );

        // ======================================
        // ユーザーごとのフォロー状況をテーブルに格納する
        // ======================================
        $unfollowed_user = FollowedAccount::where('id', $target_id)->first();
        Log::debug('$followed_user = ' . print_r($unfollowed_user, true));
        Log::debug('ユーザー [' . $target_account . '] のフォローを解除します。');
        $unfollowed_user->update(['is_follow_flag' => false]);
        $flash_message = 'ユーザー [' . $target_account . '] のフォローを解除しました。';

        return back()->with(compact('flash_message'));
    }
    
    /**
    * 自動フォローの状態（有効/無効）を変更する
    */
    public function autoFollow(Request $request)
    {
        $is_enable = $request->is_enable;
        Log::debug('>>> $is_enable = ' . $is_enable);
        $user = Auth::user();
        if ($is_enable === 'enable') {
            $user->is_auto_follow = true;
            $user->save();
            $flash_message = '自動フォローを有効にしました。';
        } else {
            $user->is_auto_follow = false;
            $user->save();
            $flash_message = '自動フォローを無効にしました。';
        }
        return back()->with(compact('flash_message'));
    }
}
