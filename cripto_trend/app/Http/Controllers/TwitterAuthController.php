<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\TwitterAuth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class TwitterAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ツイッターアカウント認証用のコントローラー
    |--------------------------------------------------------------------------
    */

    /**
     * ツイッター認証ページを表示する
     */
    public function twitterAuth()
    {
        $email = Auth::user()->email;
        $is_twitter_auth = (empty(TwitterAuth::where('email', $email)->first())) ? false : true;
        return view('twitter_auth', compact('is_twitter_auth'));
    }
    
    /**
     * リクエストトークンを取得する
     */
    public function getRequestToken()
    {
        // =============================
        // リクエストトークン取得
        // =============================
        $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
        $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';
        // $callback_url = 'http://localhost:8000/get_access_token';
        $callback_url = env('APP_URL') . '/get_access_token';
        
        // [アクセストークンシークレット] (まだ存在しないので空文字を設定)
        $access_token_secret = '';
        Log::debug("=============================================");
        Log::debug("= *** リクエストトークン取得処理を開始します。*** ==");
        Log::debug("=============================================");
        // エンドポイントURL
        $request_url = "https://api.twitter.com/oauth/request_token";
        // リクエストメソッド
        $request_method = 'POST';
        // キーを作成する (URLエンコードする)
        $signature_key = rawurlencode($api_secret) . '&' . rawurlencode($access_token_secret);
        // パラメータ([oauth_signature]を除く)を連想配列で指定
        $params = [
            "oauth_callback" => $callback_url,
            "oauth_consumer_key" => $api_key,
            "oauth_signature_method" => "HMAC-SHA1",
            "oauth_timestamp" => time(),
            "oauth_nonce" => microtime(),
            "oauth_version" => "1.0"
        ];
        // 各パラメータをURLエンコードする
        foreach($params as $key => $value) {
            // コールバックURLはエンコードしない
            if($key === "oauth_callback") {
                continue;
            }
            // URLエンコード処理
            $params[$key] = rawurlencode($value);
        }
        // 連想配列をアルファベット順に並び替える
        ksort($params);
        // パラメータの連想配列を[キー=値&キー=値...]の文字列に変換する
        $request_params = http_build_query($params, '', '&');
        // 変換した文字列をURLエンコードする
        $request_params = rawurlencode($request_params);
        // リクエストメソッドをURLエンコードする
        $encode_request_method = rawurlencode($request_method);
        // リクエストURLをURLエンコードする
        $encode_request_url = rawurlencode($request_url);
        // リクエストメソッド、リクエストURL、パラメータを[&]で繋ぐ
        $signature_data = $encode_request_method.'&'.$encode_request_url.'&'.$request_params;
        // キー[$signature_key]とデータ[$signature_data]を利用して、HMAC-SHA1方式のハッシュ値に変換する
        $hash = hash_hmac("sha1", $signature_data, $signature_key, TRUE);
        // base64エンコードして、署名[$signature]が完成する
        $signature = base64_encode($hash);
        // パラメータの連想配列、[$params]に、作成した署名を加える
        $params["oauth_signature"] = $signature;
        // パラメータの連想配列を[キー=値,キー=値,...]の文字列に変換する
        $header_params = http_build_query($params, '', ',');
        // リクエスト用のコンテキストを作成する
        $context = [
            "http" => [
                "method" => $request_method,
                "header" => [
                    "Authorization: OAuth " . $header_params,
                ],
            ],
        ];
        // cURLを使ってリクエスト
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request_url);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $context["http"]["method"]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $context["http"]["header"]);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        $res1 = curl_exec($curl);
        $res2 = curl_getinfo($curl);
        curl_close($curl);
        // 取得したデータ
        $response = substr($res1, $res2["header_size"]); // 取得したデータ（jsonなど）
        $header = substr($res1, 0, $res2["header_size"]); // レスポンスヘッダー（検証用）

        // [cURL]ではなく、[file_get_contents()]を使うには下記の通り
        // $response = file_get_contents( $request_url , false , stream_context_create( $context ) ) ;

        // リクエストトークンを取得できなかった場合
        if (!$response) {
            Log::debug('リクエストトークンを取得できませんでした…。$api_keyと$callback_url、そしてTwitterのアプリケーションに設定しているCallback URLを確認して下さい。');
            exit;
        }
        // $responseの内容(文字列)を$query(配列)に直す
        // aaa=AAA&bbb=BBB → [ "aaa"=>"AAA", "bbb"=>"BBB" ]
        $query = [];
        parse_str($response, $query);
        $request_token = $query['oauth_token'];
        $request_token_secret = $query['oauth_token_secret'];
        Log::debug('>>>>> $request_token = ' . $request_token);
        Log::debug('>>>>> $request_token_secret = ' . $request_token_secret);

        // セッションを開始
        session_start();
        session_regenerate_id(true);
        $_SESSION['request_token'] = $request_token;
        $_SESSION['request_token_secret'] = $request_token_secret;
    
        // ユーザーを認証画面へ飛ばす
        Log::debug('>>>>> 認証画面へ遷移します。');
        $url = "https://api.twitter.com/oauth/authenticate?oauth_token=" . $request_token;
        return redirect($url);
    }

    /**
     * アクセストークンを取得する
     */
    public function getAccessToken()
    {
        // ========================
        // アクセストークン取得
        // ========================
        if (isset($_GET["oauth_token"]) && isset($_GET["oauth_verifier"])) {
            Log::debug("=============================================");
            Log::debug("== *** アクセストークン取得処理を開始します。*** ==");
            Log::debug("=============================================");

            $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
            $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';    
            session_start();
            $request_token_secret = $_SESSION['request_token_secret'];
            // リクエストURL
            $request_url = "https://api.twitter.com/oauth/access_token";
            // リクエストメソッド
            $request_method = "POST";
            // キーを作成する
            $signature_key = rawurlencode($api_secret).'&'.rawurlencode($request_token_secret);
            // パラメータ([oauth_signature]を除く)を連想配列で指定
            $params = [
                "oauth_consumer_key" => $api_key,
                "oauth_token" => $_GET['oauth_token'],
                "oauth_signature_method" => "HMAC-SHA1",
                "oauth_timestamp" => time(),
                "oauth_verifier" => $_GET['oauth_verifier'],
                "oauth_nonce" => microtime(),
                "oauth_version" => "1.0",
            ];
            // 配列の各パラメータの値をURLエンコード
            foreach ($params as $key => $value) {
                $params[$key] = rawurlencode($value);
            }
            // 連想配列をアルファベット順に並び替え
            ksort($params);
            // パラメータの連想配列を[キー=値&キー=値...]の文字列に変換
            $request_params = http_build_query($params, '', '&');
            // 変換した文字列をURLエンコードする
            $request_params = rawurlencode($request_params);
            // リクエストメソッドをURLエンコードする
            $encode_request_method = rawurlencode($request_method);
            // リクエストURLをURLエンコードする
            $encode_request_url = rawurlencode($request_url);
            // リクエストメソッド、リクエストURL、パラメータを[&]で繋ぐ
            $signature_data = $encode_request_method.'&'.$encode_request_url.'&'.$request_params;
            // キー[$signature_key]とデータ[$signature_data]を利用して、HMAC-SHA1方式のハッシュ値に変換する
            $hash = hash_hmac('sha1', $signature_data, $signature_key, TRUE);
            // base64エンコードして、署名[$signature]が完成する
            $signature = base64_encode($hash);
            // パラメータの連想配列、[$params]に、作成した署名を加える
            $params['oauth_signature'] = $signature;
            // パラメータの連想配列を[キー=値,キー=値,...]の文字列に変換する
            $header_params = http_build_query($params, '', ',');
            // リクエスト用のコンテキストを作成する
            $context = [
                "http" => [
                    "method" => $request_method,
                    "header" => [
                        "Authorization: OAuth ".$header_params,
                    ],
                ],
            ];
            // cURLを使ってリクエスト
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $request_url);
            curl_setopt($curl, CURLOPT_HEADER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $context['http']['method']);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $context['http']['header']);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            $res1 = curl_exec($curl);
            $res2 = curl_getinfo($curl);
            curl_close($curl);
            // 取得したデータ
            $response = substr($res1, $res2['header_size']);
            $header = substr($res1, 0, $res2['header_size']);

            // $responseの内容(文字列)を$query(配列)に直す
            // aaa=AAA&bbb=BBB → [ "aaa"=>"AAA", "bbb"=>"BBB" ]
            $response_array = [];
            parse_str($response, $response_array);
            // 配列の内容を出力する (デバッグ用)
            // foreach ($response_array as $key => $value) {
            //     Log::debug('>>>>> ' . $key . ':' . $value);
            // }
            $email = Auth::User()->email;
            $access_token = $response_array['oauth_token'];
            $access_token_secret = $response_array['oauth_token_secret'];
            Log::debug('>>>>> $email = ' . $email);
            Log::debug('>>>>> $access_token = ' . $access_token);
            Log::debug('>>>>> $access_token_secret = ' . $access_token_secret);

            Log::debug('>>>>> mb_strlen(encrypt($access_token)) = ' . mb_strlen(encrypt($access_token)));
            Log::debug('>>>>> mb_strlen(encrypt($access_token_secret)) = ' . mb_strlen(encrypt($access_token_secret)));

            // アクセストークンをDBに登録
            $flash_message = '';
            $twitterAuth = TwitterAuth::where('email', $email)->first();
            if (empty($twitterAuth)) {
                Log::debug('>>>>> ' . 'ユーザー [' . $email . '] のアクセストークンを新規に登録します。');
                twitterAuth::create([
                    'email' => $email,
                    'access_token' => base64_encode($access_token),
                    'access_token_secret' => base64_encode($access_token_secret),
                    // 'access_token' => Crypt::encryptString($access_token),
                    // 'access_token_secret' => Crypt::encryptString($access_token_secret),
                    // 'access_token' => encrypt($access_token),
                    // 'access_token_secret' => encrypt($access_token_secret),
                ]);
                $flash_message = 'Twitterアカウントの認証に成功しました。';
            }
        } elseif (isset($_GET["denied"])) {
            // エラーメッセージを出力して終了
            Log::debug('>>>>> 連携を拒否しました。');
            exit;
        }

        $is_twitter_auth = (empty($twitterAuth)) ? false : true;
        return view('twitter_auth', compact('is_twitter_auth'))->with(compact('flash_message'));
    }
}
