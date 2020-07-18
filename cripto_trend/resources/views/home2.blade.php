<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home | Cripto Trend</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    
</head>
<body>
    @php
        use Illuminate\Support\Facades\Log;
        // require 'vendor/autoload.php';
        use Abraham\TwitterOAuth\TwitterOAuth;
        
        // PHP処理のタイムアウト時間を変更（デフォルト30s->120s）
        set_time_limit(120);
        
        // $ak = 'u8GXSucbr7JvGzWb2TonppQgL';
        // $as = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';
        // $at = '831669493621350401-dWf8Z2kmMjHe4q6MnP3136pfImtaPI3';
        // $ts = '7J9HYDfw9wVWuOsrHyJmouRAUoB5yV0IMLYNlnIT2KmWe';
        
        // =============================
        // 自動ツイートするロジック
        // =============================
        // $connect = new TwitterOAuth($ak, $as, $at, $ts);
        // $tweet = 'test';
        // $result = $connect->post(
            //     'statuses/update',
            //     ['status' => $tweet]
            // );
            // =============================
            
            // =============================
            // ベアラートークンの取得
            // =============================
            // クレデンシャルの作成
            // $credential = base64_encode($ak, . ':' . $as);
            
            // ==========================================
            // 指定したキーワードを含むツイートを取得するロジック
            // ==========================================
            // $connect = new TwitterOAuth($ak, $as, $at, $ts);
            // $statuses = $connect->get(
                //     'search/tweets',
                //     [
                    //         'q' => '仮想通貨',
                    //         'count' => '3',
                    //         'lang' => 'ja',
                    //         'locale' => 'ja',
                    //         'result_type' => 'recent',
                    //         'include_entities' => 'false'
                    //     ]
                    // );
                    
                    // ==========================================
                    // 署名の作成サンプル
                    // ==========================================
                    // // oauth_consumer_secret
                    // $oauth_consumer_secret = 'bbbbbb';
                    // // [oauth_consumer_secret]をURLエンコード
                    // $encode_a = rawurlencode($oauth_consumer_secret);
                    // // oauth_token_secret
                    // $oauth_token_secret = 'dddddd';
                    // // [oauth_token_secret]をURLエンコード
                    // $encode_b = rawurlencode($oauth_token_secret);
                    // // 2つの値を[&]で繋いで署名キー[$signature_key]が完成する
                    // $signature_key = $encode_a . '&' . $encode_b;
                    // // リクエストメソッド
                    // $request_method = 'POST';
                    // // リクエストURL
                    // $request_url = 'http://example.com/sample.php';
                    // // リクエストメソッドをURLエンコード
                    // $request_method_encode = rawurlencode($request_method);
                    // // リクエストURLをエンコード
                    // $request_url_encode = rawurlencode($request_url);
                    // // パラメータ(連想配列形式)
                    // $params = [
                        //     'title' => 'AAA',
                        //     'name' => 'BBB',
                        //     'text' => 'CCC'
                        // ];
                        // // 連想配列のキーをアルファベット順に並び替える
                        // ksort($params);
                        // // 配列の各パラメータの値をURLエンコード
                        // foreach($params as $key => $value) {
                            //     $params[$key] = rawurlencode($value);
                            // }
                            // // 連想配列[$params]を[キー=値&キー=値]の形式に組み立てる
                            // $request_params = http_build_query($params, '', '&');
                            // // 組み立てたパラメータをURLエンコードする
                            // $request_params = rawurlencode($request_params);
                            // // メソッド[$request_method]、URL[$request_url]、パラメータ[$request_params]の順に[&]で繋げる
                            // $signature_data = $request_method_encode . '&' . $request_url_encode . '&' . $request_params;
                            // // HMAC-SHA1方式のハッシュ値に変換
                            // $hash = hash_hmac('sha1', $signature_data, $signature_key, TRUE);
                            // // ハッシュ値をbase64エンコードして署名の完成
                            // $signature = base64_encode($hash);
                            
                            // ==========================================
                            // アクセストークン取得までの流れ
                            // ==========================================
                            // 1. リクエストトークンを取得する
                            // 2. リクエストトークンをパラメータに付けて、ユーザーを認証画面に飛ばす
                            // 3. ユーザーが、認証画面でアプリ連携を許可する
                            // 4. 許可証となるコードをパラメータに付けて、ユーザーがCallBack URLで設定した
                            // 　　URLアドレスに飛ばされてくる
                            // 5. 許可証となるコードを利用して、アクセストークンを取得する
                            
                            // ==========================================
                            // リクエストトークン取得
                            // ==========================================
                            $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
                            $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';
                            $callback_url = 'http://localhost:8000/home';
                            // [アクセストークンシークレット] (まだ存在しないので「なし」)
                            $access_token_secret = '';
                            if (empty($_GET["oauth_token"]) && empty($_GET["oauth_verifier"])) {
                                Log::debug(">>>>> リクエストトークン取得処理に入りました。>>>>>");
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
                                // [cURL]ではなく、[file_get_contents()]を使うには下記の通りです…
                                // $response = file_get_contents( $request_url , false , stream_context_create( $context ) ) ;
                                // リクエストトークンを取得できなかった場合
                                if (!$response) {
                                    echo "<p>リクエストトークンを取得できませんでした…。$api_keyと$callback_url、そしてTwitterのアプリケーションに設定しているCallback URLを確認して下さい。</p>" ;
                                    exit;
                                }
                                // $responseの内容(文字列)を$query(配列)に直す
                                // aaa=AAA&bbb=BBB → [ "aaa"=>"AAA", "bbb"=>"BBB" ]
                                $query = [];
                                parse_str($response, $query);
                                // 配列の内容を出力する (本番では不要)
                                foreach($query as $key => $value) {
                                    // echo "<b>" . $key . "</b>: " . $value . "<BR>" ; 
                                    Log::debug('***** key='.$key.' ***** value='.$value);
                                }
                                session_start();
                                session_regenerate_id(true);
                                $_SESSION["oauth_token_secret"] = $query["oauth_token_secret"];
                                // ユーザーを認証画面へ飛ばす (毎回ボタンを押す場合)
                                // header("Location: https://api.twitter.com/oauth/authorize?oauth_token=".$query["oauth_token"]);
                                // echo '<p><a href="https://api.twitter.com/oauth/authenticate?oauth_token=' . $query["oauth_token"] . '">認証画面へ移動する</a></p>';
                                // ユーザーを認証画面へ飛ばす (二回目以降は認証画面をスキップする場合)
                                // header( "Location: https://api.twitter.com/oauth/authenticate?oauth_token=" . $query["oauth_token"] );
                                    
                            } else {
                                Log::debug(">>>>> リクエストトークンは取得済みです。 >>>>>");
                            }

                            // 「連携アプリを認証」をクリックして帰ってきた時
                            if (isset($_GET["oauth_token"]) && isset($_GET["oauth_verifier"])) {
                                // アクセストークンを取得するための処理
                                session_start();
                                $request_token_secret = $_SESSION['oauth_token_secret'];
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
                                // 配列の内容を出力する (本番では不要)
                                foreach ($response_array as $key => $value) {
                                    Log::debug('>>>>> ' . $key . ':' . $value);
                                }
                                $access_token = $response_array['oauth_token'];
                                $access_token_secret = $response_array['oauth_token_secret'];
                                // ==========================================
                                // 指定したユーザーのツイートを取得するロジック
                                // ==========================================
                                $connect = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
                                $timeline = $connect->get(
                                    'statuses/user_timeline',
                                    [
                                        'screen_name' => '@kazukichi3110',
                                        'count' => '20'
                                    ],
                                );
                                // ==========================================
                                // ユーザーを検索
                                // ==========================================
                                $users = $connect->get(
                                    'users/search',
                                    [
                                        'q' => 'SaramanderOle',
                                        'count' => '10',
                                        'include_entities' => 'true',
                                    ],
                                );
                                
                                // ==========================================
                                // ツイートを検索
                                // ==========================================
                                define('REQUEST_MAX_COUNT', 180);
                                define('TWEET_COUNT_PER_REQUEST', 100);
                                $currencyCode = 'BTC';
                                $currency_codes = [
                                    'ビットコイン' => 'BTC',
                                    'イーサリアム' => 'ETH',
                                    'イーサリアムクラシック' => 'ETC',
                                    'リスク' => 'LSK',
                                    'ファクトム' => 'FCT',
                                    'リップル' => 'XRP',
                                    'ネム' => 'XEM',
                                    'ライトコイン' => 'LTC',
                                    'ビットコインキャッシュ' => 'BCH',
                                    'モナーコイン' => 'MONA',
                                    'ステラ・ルーメン' => 'XLM',
                                    'クアンタム' => 'QTUM',
                                ];
                                $currency_names = [
                                    'BTC' => 'ビットコイン',
                                    'ETH' => 'イーサリアム',
                                    'ETC' => 'イーサリアムクラシック',
                                    'LSK' => 'リスク',
                                    'FCT' => 'ファクトム',
                                    'XRP' => 'リップル',
                                    'XEM' => 'ネム',
                                    'LTC' => 'ライトコイン',
                                    'BCH' => 'ビットコインキャッシュ',
                                    'MONA' => 'モナーコイン',
                                    'XLM' => 'ステラ・ルーメン',
                                    'QTUM' => 'クアンタム',
                                ];
                                
                                $request_count = 0;
                                $tweet_count = [
                                    'BTC' => 0,
                                    'ETH' => 0,
                                    'ETC' => 0,
                                    'LSK' => 0,
                                    'FCT' => 0,
                                    'XRP' => 0,
                                    'XEM' => 0,
                                    'LTC' => 0,
                                    'BCH' => 0,
                                    'MONA' => 0,
                                    'XLM' => 0,
                                    'QTUM' => 0,
                                ];
                                $params = [
                                    'q' => $currencyCode . ' OR ' . $currency_names[$currencyCode],
                                    'lang' => 'ja',
                                    'count' => TWEET_COUNT_PER_REQUEST,
                                    // 'since' => '2020-06-17_12:00:00_JST',
                                    // 'until' => '2020-06-19_12:00:00_JST',
                                ];
                                while (true) {
                                    $tweets_response = $connect->get('search/tweets', $params);
                                    if (property_exists($tweets_response, 'errors')) {
                                        $errors = $tweets_response->errors;
                                        // TwitterAPIの制限である180req/15minを超えた場合、エラーコード88が返ってくる
                                        if ($errors[0]->code === 88) {
                                            sleep(60*15);
                                            continue;
                                        } else {
                                            Log::debug('レスポンスがエラーのため、処理を終了します。');
                                            exit;
                                        }
                                    }
                                    // if ($request_count < REQUEST_MAX_COUNT) {
                                        //     // Log::debug('>>>>> $connect->get直前のparams = ' . print_r($params, true));
                                        //     $tweets_response = $connect->get('search/tweets', $params);
                                        //     $request_count += 1;
                                        // } else {
                                            //     // 180リクエストした場合は15分待つ
                                            //     sleep(60*15);
                                            //     $request_count = 0;
                                            //     continue;
                                            // }
                                            // レスポンスオブジェクトからツイートオブジェクトを取得
                                            // if (!property_exists($tweets_response, 'statuses')) {
                                                //     Log::debug('レスポンスオブジェクトにstatusesプロパティが存在しません。処置を中断します。');
                                                //     Log::debug('$tweets_response = ' . print_r($tweets_response, true));
                                                //     $errors = $tweets_response->errors;
                                                //     Log::debug('$errors = ' . print_r($errors, true));
                                                //     Log::debug('code = ' . $errors[0]->code);
                                                //     $code = $tweets_response->errors[0]->code;
                                                //     Log::debug('code_2 = ' . $code);
                                                // TODO
                                                // codeが88だったらリクエスト上限を超えたとみなせるか？
                                                // もしみなせるならば、、、
                                                // 1. レスポンスオブジェクトにerrorsプロパティが存在するかチェック
                                                // 2. errorsプロパティが存在していればerrorsに紐づく配列の0番目の要素のcodeプロパティを参照する
                                                // 3. codeプロパティの値が88であればリクエスト上限エラーとして、15分待つ
                                                // 4. リスクで検索すると仮想通貨以外のツイートもカウントしてしまうのでLSKで検索するか？（リスク以外の通貨はどうする？）
                                                // 5. ORを使うと複数キーワード指定できるみたい  q => "iOS7 OR macbookpro"
                                                //     break;
                                                // }
                                    $tweets_obj = $tweets_response->statuses;
                                    // レスポンスオブジェクトからメタデータオブジェクトを取得
                                    $search_metadata_obj = $tweets_response->search_metadata;
                                        
                                    if (property_exists($search_metadata_obj, 'next_results')) {
                                        foreach ($tweets_obj as $tweet) {
                                            $tweet_count[$currencyCode] += 1;
                                        }
                                        $next_results = preg_replace('/^\?/', '', $search_metadata_obj->next_results);
                                        Log::debug('現在までの' . $currency_names[$currencyCode] . 'のツイート数は、' . $tweet_count[$currencyCode] . '件です。');
                                        // Log::debug('>>>>> $next_result = ' . $next_results);
                                        parse_str($next_results, $params);
                                        // Log::debug('>>>>> parse_str直後のparams = ' . print_r($params, true));
                                    } else {
                                        // ここのループは多分いらない（next_resultsがないということは検索結果がが0件のはずだから）
                                        foreach ($tweets_obj as $tweet) {
                                            $tweet_count[$currencyCode] += 1;
                                            Log::debug('tweet->user->screen_name = ' . $tweet->user->screen_name);
                                            Log::debug('tweet->text = ' . mb_substr($tweet->text, 0, 20));
                                            Log::debug('tweet->created_at = ' . date('Y-m-d H:i:s', strtotime($tweet->created_at)));
                                            Log::debug('現在までの' . $currency_names[$currencyCode] . 'のツイート数は、' . $tweet_count[$currencyCode] . '件です。');
                                        }
                                        Log::debug('break直前の$search_metadata_obj = ' . print_r($search_metadata_obj,true));
                                        Log::debug('break直前の$tweets_obj = ' . print_r($tweets_obj,true));
                                        Log::debug('>>>>>>> while文をbreakします。');
                                        break;
                                    }
                                }
                                Log::debug('>>>>> ' . $currency_names[$currencyCode] . 'のツイート数は [' . $tweet_count[$currencyCode] . '] 件です。');
                                    
                                // 「キャンセル」をクリックして帰ってきた時
                            } elseif (isset($_GET["denied"])) {
                                // エラーメッセージを出力して終了
                                Log::debug('>>>>> 連携を拒否しました。');
                                exit;
                            }
                                        
                            // $now = date('Y-m-d H:i:s');
                            // $an_hour_ago = date('Y-m-d H:i:s', strtotime('-1 hour'));
                            // Log::debug('>>>>> $now = ' . $now);
                            // Log::debug('>>>>> $an_hour_ago = ' . $an_hour_ago);
                            $bitCount = 2000;  
                            @endphp
    <header>
        <nav class="l-header is-relative">
            <h1 class="p-header__title"><a href="/">Cripto Trend</a></h1>
            <ul class="l-list__container">
                <li class="l-list__item"><a class="c-header__menu" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                <li class="l-list__item"><a class="c-header__menu" href="{{ route('register') }}">{{ __('Register') }}</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="c-base__container">
            <div class="c-checkbox__area">
                <div class="c-select-currency">
                    <h2 class="c-select-currency__title">対象の通貨を選択</h2>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="all" checked="checked"><span class="c-checkbox__label">全ての通貨</span>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="BTC"><a href=""><span class="c-checkbox__label">ビットコイン(BTC)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="ETH"><a href=""><span class="c-checkbox__label">イーサリアム(ETH)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="ETC"><a href=""><span class="c-checkbox__label">イーサリアムクラシック(ETC)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="LSK"><a href=""><span class="c-checkbox__label">リスク(LSK)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="FCT"><a href=""><span class="c-checkbox__label">ファクトム(FCT)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="XRP"><a href=""><span class="c-checkbox__label">リップル(XRP)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="XEM"><a href=""><span class="c-checkbox__label">ネム(XEM)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="LTC"><a href=""><span class="c-checkbox__label">ライトコイン(LTC)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="BCH"><a href=""><span class="c-checkbox__label">ビットコインキャッシュ(BCH)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="MONA"><a href=""><span class="c-checkbox__label">モナーコイン(MONA)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="XLM"><a href=""><span class="c-checkbox__label">ステラ・ルーメン(XLM)</span></a>
                    </div>
                    <div class="c-checkbox__container">
                        <input type="checkbox" class="c-checkbox__item" name="currencies[]" value="QTUM"><a href=""><span class="c-checkbox__label">クアンタム(QTUM)</span></a>
                    </div>
                </div>
            </div>
            <div class="c-trend-ranking">
                <div class="c-term">
                    <div class="c-term__container">
                        <label for="term-select">
                            <h2 class="c-term__title">集計期間</h2>
                        </label>
                        <div class="c-term__select">
                            <select name="term" class="c-selectbox__area" id="term-select">
                                <option value="hour">過去１時間</option>
                                <option value="day" selected>過去１日</option>
                                <option value="week">過去１週間</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="c-time">
                    <span class="c-time__label">{{ date('Y-m-d H:i') . ' 現在' }}</span>
                </div>
                <div class="c-currency__container">
                    {{-- <div class="c-currency-header">
                        <ul class="c-currency-list">
                            <li class="c-currency-list__item">銘柄名</li>
                            <li class="c-currency-list__item">ツイート数</li>
                            <li class="c-currency-list__item">最高取引価格</li>
                            <li class="c-currency-list__item">最低取引価格</li>
                        </ul>
                    </div> --}}
                    <table class="c-currency-table">
                        <thead>
                            <tr class="c-currency-table__header">
                                <th class="c-currency-table__title">銘柄名</th>
                                <th class="c-currency-table__title">ツイート数</th>
                                <th class="c-currency-table__title">最高取引価格</th>
                                <th class="c-currency-table__title">最低取引価格</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="c-currency-table__row">
                                <td class="c-currency-table__data u-text-center"><a href="https://twitter.com/home" target="_blank">ビットコイン</a> </td>
                                <td class="c-currency-table__data u-text-right">{{ $bitCount }}</td>
                                <td class="c-currency-table__data u-text-right">850,000</td>
                                <td class="c-currency-table__data u-text-right">780,000</td>
                            </tr>
                        </tbody>
                    </table>
                    {{-- @foreach($statuses->statuses as $tweet)
                        <div>
                            {{ 'id : ' . $tweet->id }}
                            {{ 'text : ' . $tweet->text }}
                        </div>
                        @endforeach --}}
                        {{-- {{ "signature = {$signature}" }} --}}
                        {{-- <div>
                            <textarea cols="80" rows="10">{{ "response = {$response}" }}</textarea>
                        </div>
                        <div>
                            <textarea cols="80" rows="10">{{ "header = {$header}" }}</textarea>
                        </div> --}}
                        @if (!empty($query) && isset($query['oauth_token']))
                        <p><a href="https://api.twitter.com/oauth/authenticate?oauth_token={{$query['oauth_token']}}">認証画面へ移動する</a></p>
                        @endif
                        @if (isset($users))
                        @foreach($users as $user)
                        <div>
                            <p>{{ "name={$user->name}" }}</p>
                            <p>{{ "screen_name={$user->screen_name}" }}</p>
                            <p>{{ "description={$user->description}" }}</p>
                        </div>
                        @endforeach
                        @endif
                        @php
                    // $since = date('Y-m-d H:i:s', time());
                    $until = date('Y-m-d_12:00:00').'_JST';
                    $since = date('Y-m-d_12:00:00', strtotime('-1 day')).'_JST';
                    echo 'since = ' . $since;
                    echo '<br>';
                    echo 'until = ' . $until;
                    echo '<br>';
                    echo $tweet_counts_array['BTC_WEEK'];
                    // TODO　vueを使って画面を動的に制御する。まずはvueの使い方の復習から！
                    @endphp
                {{-- @foreach ($tweet_counts as $tweet_count)
                    <p>{{ "currency_code={$tweet_count->currency_code}" }}</p>
                    <p>{{ "count={$tweet_count->count}" }}</p>
                    @endforeach --}}
                </div>
                <div id="app">
                    <example-component></example-component>
                </div>
            </div>
        </main>
        <footer>
            <div class="l-footer">
                ©️ 2020 Yasunori Matsuoka
            </div>
        </footer>
        @if (isset($timeline))
            @foreach($timeline as $tweet)
            <div>
                {{ 'screen_name : ' . $tweet->user->screen_name }}
                {{ "text : {$tweet->text}" }}
                {{ date("Y/m/d H:i:s", strtotime($tweet->created_at)) }}
            </div>
            @endforeach
        @endif
        {{-- Scripts --}}
        <script src="{{ asset('/js/app.js') }}"></script>
    </body>
    </html>  