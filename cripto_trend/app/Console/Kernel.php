<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Candidate;
use App\FollowedAccount;
use App\TweetCount;
use App\TwitterAuth;
use App\Library\Common;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // ==========================================
        // 仮想通貨含むユーザー検索処理
        // ==========================================  
        $schedule->call(function() {
            $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
            $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';
            $access_token = '831669493621350401-dWf8Z2kmMjHe4q6MnP3136pfImtaPI3';
            $access_token_secret = '7J9HYDfw9wVWuOsrHyJmouRAUoB5yV0IMLYNlnIT2KmWe';
            $connect = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
            $keyword = '仮想通貨';
            $page = 1;
            $count = 20;
            $params = [
                'q' => $keyword,
                'page' => $page,
                'count' => $count,
                'include_entities' => false,
            ];
            while (true) {
                Log::debug('>>>>>>>>>> 「' . $keyword . '」を含むユーザーを検索します('.$page.'ページ目)。 >>>>>>>>>>');
                $candidates = $connect->get('users/search', $params);

                if (is_object($candidates) && property_exists($candidates, 'errors')) {
                    $errors = $candidates->errors;
                    if ($errors[0]->code === 44) {
                        Log::debug('検索結果利用数が上限に達したため処理を終了します。');
                        break;
                    }
                }

                if (is_array($candidates)) {
                    Log::debug('>>>>> count($candidates = ' . count($candidates));
                }

                foreach ($candidates as $key => $candidate) {
                    Log::debug('>>>>> Current user is [' . $candidate->screen_name . '].');
                    // 最新ツイートがある程度過去の場合、当該ユーザーのstatusプロパティは存在しないため固定の文言(No Data)を設定する
                    if (property_exists($candidate, 'status')) {
                        $latest_tweet = $candidate->status->text;
                    } else {
                        $latest_tweet = 'No data.';
                    }
                    if (DB::table('candidates')->where('twitter_user_name', $candidate->screen_name)->exists()) {
                        // 該当アカウントがテーブルにある場合
                        Log::debug('>>>>> 更新します。 >>>>>');
                        Candidate::where('twitter_user_name', $candidate->screen_name)->update([
                            'twitter_account_name' => $candidate->name,
                            'follows_count' => $candidate->friends_count,
                            'followers_count' => $candidate->followers_count,
                            'profile' => $candidate->description,
                            'latest_tweet' => $latest_tweet,
                        ]);
                    } else {
                        // 該当アカウントがテーブルにない場合
                        Log::debug('>>>>> 登録します。 >>>>>');
                        Candidate::create([
                            'twitter_user_name' => $candidate->screen_name,
                            'twitter_account_name' => $candidate->name,
                            'follows_count' => $candidate->friends_count,
                            'followers_count' => $candidate->followers_count,
                            'profile' => $candidate->description,
                            'latest_tweet' => $latest_tweet,
                        ]);
                    }
                }
                $page += 1;
                $params['page'] = $page;
            }
        })->dailyAt('4:00');

        // ==========================================
        // Twitterアカウント自動フォロー処理
        // ==========================================
        $schedule->call(function() {
            Log::debug('===== Start auto follow process. =====');
            
            define('FOLLOWABLE_MAX_COUNT', 15);
            $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
            $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';

            // 自動フォロー機能を有効にしているユーザーのみ処理を実施
            $target_users = DB::table('users')->where('is_auto_follow', true)->get();
            
            foreach ($target_users as $user) {
                $email = $user->email;
                Log::debug('===== $email = ' . $email);
                $access_token = base64_decode(TwitterAuth::where('email', $email)->value('access_token'));
                Log::debug('===== $access_token = ' . $access_token);
                $access_token_secret = base64_decode(TwitterAuth::where('email', $email)->value('access_token_secret'));
                Log::debug('===== $access_token_secret = ' . $access_token_secret);
                
                // フォロー対象（フォロー未済）のアカウントを検索
                $followed_this_user = DB::table('followed_accounts')
                                        ->select('id', 'twitter_user_name', 'is_follow_flag')
                                        ->where('email', '=', $email);
                $candidates = DB::table('candidates')
                                ->leftJoinSub($followed_this_user, 'followed_this_user', function ($join) {
                                    $join->on('candidates.twitter_user_name', '=', 'followed_this_user.twitter_user_name');
                                })->select('candidates.*', 'followed_this_user.id as followed_account_id')
                                    ->where('followed_this_user.is_follow_flag', null)
                                    ->orWhere('followed_this_user.is_follow_flag', false)
                                    ->orderBy('candidates.followers_count', 'DESC')
                                    ->get();

                $followed_count = 0;
                $connect = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
                foreach($candidates as $candidate) {
                    $twitter_user_name = $candidate->twitter_user_name;

                    Log::debug('======== 自動フォローを実施 ========');
                    Log::debug('$user->email = ' . $user->email);
                    Log::debug('$candidate->twitter_user_name' . $twitter_user_name);
                    Log::debug('=================================');

                    // 15account/15minの制限のため
                    if ($followed_count === FOLLOWABLE_MAX_COUNT) {
                        Log::debug('===== フォロー数が15件に達したためループを抜けます。 =====');
                        break;
                    }
                    $do_follow = $connect->post(
                        'friendships/create',
                        [
                            'screen_name' => $twitter_user_name,
                        ],
                    );
                    $followed_count += 1;

                    // ======================================
                    // フォロー状況をテーブルに格納する
                    // ======================================
                    $is_exist_account = DB::table('followed_accounts')
                                        ->where('id', $candidate->followed_account_id)
                                        ->exists();
                    $followed_account = FollowedAccount::where('id', $candidate->followed_account_id)->first();
                    if (empty($followed_account)) {
                        FollowedAccount::create([
                            'email' => $email,
                            'twitter_user_name' => $twitter_user_name,
                            'is_follow_flag' => true,
                            'user_id' => $user->id,
                            'candidate_id' => $candidate->id,
                            ]);
                    } else {
                        $followed_account->update(['is_follow_flag' => true]);
                    }
                    Log::debug('ユーザー [' . $twitter_user_name . '] をフォローしました。');
                }
            }
            Log::debug('===== End auto follow process. =====');
        // 1000account/1dayの上限があるため30分間隔で実行
        })->everyThirtyMinutes();

        // ==========================================
        // 通貨別ツイート数取得処理
        // ==========================================  
        // 過去一週間分
        $schedule->call(function() {
            Log::debug('>>>>>>>>>> 過去１週間分の通貨別のツイート数を取得します。 >>>>>>>>>>');
            // ==========================================
            // ツイートを検索
            // ==========================================
            $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
            $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';
            $access_token = '831669493621350401-dWf8Z2kmMjHe4q6MnP3136pfImtaPI3';
            $access_token_secret = '7J9HYDfw9wVWuOsrHyJmouRAUoB5yV0IMLYNlnIT2KmWe';
            $connect = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
            // define('REQUEST_MAX_COUNT', 180);
            define('TWEET_COUNT_PER_REQUEST', 100);
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
            $request_count = 0;
            $suffix = '_WEEK';
            foreach ($currency_names as $key => $value) {
                Log::debug('>>>>> This currency is ' . $key);
                $params = [
                    'q' => '#'.$key . ' OR ' . '#'.$value,
                    // 'q' => $value,
                    'lang' => 'ja',
                    'count' => TWEET_COUNT_PER_REQUEST,
                ];
                while (true) {
                    $tweets_response = $connect->get('search/tweets', $params);
                    if (property_exists($tweets_response, 'errors')) {
                        $errors = $tweets_response->errors;
                        // TwitterAPIの制限である180request/15minを超えた場合、エラーコード88が返ってくる
                        if ($errors[0]->code === 88) {
                            Log::debug('リクエスト数の上限に達したため、15分待機します。');
                            sleep(60*15);
                            continue;
                        } else {
                            Log::debug('予期しないエラーが発生したため、処理を終了します。');
                            Log::debug('>>>>> $errors = ' . print_r($errors, true));
                            exit;
                        }
                    }
                    // レスポンスオブジェクトからツイートオブジェクトを取得
                    $tweets_obj = $tweets_response->statuses;
                    // レスポンスオブジェクトからメタデータオブジェクトを取得
                    $search_metadata_obj = $tweets_response->search_metadata;

                    if (property_exists($search_metadata_obj, 'next_results')) {
                        foreach ($tweets_obj as $tweet) {
                            $tweet_count[$key] += 1;
                        }
                        $next_results = preg_replace('/^\?/', '', $search_metadata_obj->next_results);
                        // Log::debug('現在までの' . $value . 'のツイート数は、' . $tweet_count[$key] . '件です。');
                        parse_str($next_results, $params);
                    } else {
                        break;
                    }
                }
                Log::debug('Now is ' . date('Y-m-d H:i:s', time()));
                Log::debug('>>>>> ' . $value . 'のツイート数は [' . $tweet_count[$key] . '] 件です。');
                $currency_code = $key . $suffix;
                $tweet_count_obj = TweetCount::where('currency_code', $currency_code)->first();
                if (empty($tweet_count_obj)) {
                    Log::debug('currency_codeが' . $currency_code . 'のデータは存在しません。新規登録します。');
                    TweetCount::create([
                        'currency_code' => $currency_code,
                        'count' => $tweet_count[$key],
                    ]);
                } else {
                    Log::debug('currency_codeが' . $currency_code . 'のデータは存在します。データを更新します。');
                    TweetCount::where('currency_code', $currency_code)->update(['count' => $tweet_count[$key]]);
                }
            }
        // })->twiceDaily(5, 17);
        })->dailyAt('0:00');

        // 過去一日分
        $schedule->call(function() {
            Log::debug('>>>>>>>>>> 過去１日分の通貨別のツイート数を取得します。 >>>>>>>>>>');
            // ==========================================
            // ツイートを検索
            // ==========================================
            $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
            $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';
            $access_token = '831669493621350401-dWf8Z2kmMjHe4q6MnP3136pfImtaPI3';
            $access_token_secret = '7J9HYDfw9wVWuOsrHyJmouRAUoB5yV0IMLYNlnIT2KmWe';
            $connect = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
            define('TWEET_COUNT_PER_REQUEST', 100);
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
            $request_count = 0;
            $suffix = '_DAY';
            $since = date('Y-m-d_H:00:00', strtotime('-1 day')).'_JST';
            $until = date('Y-m-d_H:00:00').'_JST';
            foreach ($currency_names as $key => $value) {
                Log::debug('>>>>> This currency is ' . $key);
                $params = [
                    'q' => '#'.$key . ' OR ' . '#'.$value,
                    'lang' => 'ja',
                    'count' => TWEET_COUNT_PER_REQUEST,
                    'since' => $since,
                    'until' => $until,
                ];
                while (true) {
                    $tweets_response = $connect->get('search/tweets', $params);
                    if (property_exists($tweets_response, 'errors')) {
                        $errors = $tweets_response->errors;
                        // TwitterAPIの制限である180request/15minを超えた場合、エラーコード88が返ってくる
                        if ($errors[0]->code === 88) {
                            Log::debug('リクエスト数の上限に達したため、15分待機します。');
                            sleep(60*15);
                            continue;
                        } else {
                            Log::debug('予期しないエラーが発生したため、処理を終了します。');
                            exit;
                        }
                    }
                    // レスポンスオブジェクトからツイートオブジェクトを取得
                    $tweets_obj = $tweets_response->statuses;
                    // レスポンスオブジェクトからメタデータオブジェクトを取得
                    $search_metadata_obj = $tweets_response->search_metadata;

                    if (property_exists($search_metadata_obj, 'next_results')) {
                        foreach ($tweets_obj as $tweet) {
                            $tweet_count[$key] += 1;
                        }
                        $next_results = preg_replace('/^\?/', '', $search_metadata_obj->next_results);
                        parse_str($next_results, $params);
                    } else {
                        break;
                    }
                }
                Log::debug('>>>>> ' . $value . 'のツイート数は [' . $tweet_count[$key] . '] 件です。');
                $currency_code = $key . $suffix;
                $tweet_count_obj = TweetCount::where('currency_code', $currency_code)->first();
                if (empty($tweet_count_obj)) {
                    Log::debug('currency_codeが' . $currency_code . 'のデータは存在しません。新規登録します。');
                    TweetCount::create([
                        'currency_code' => $currency_code,
                        'count' => $tweet_count[$key],
                    ]);
                } else {
                    Log::debug('currency_codeが' . $currency_code . 'のデータは存在します。データを更新します。');
                    TweetCount::where('currency_code', $currency_code)->update(['count' => $tweet_count[$key]]);
                }
            }
        })->twiceDaily(6, 18);

        // 過去一時間分
        $schedule->call(function() {
            Log::debug('>>>>>>>>>> 過去１時間分の通貨別のツイート数を取得します。 >>>>>>>>>>');
            // ==========================================
            // ツイートを検索
            // ==========================================
            $api_key = 'u8GXSucbr7JvGzWb2TonppQgL';
            $api_secret = 'rYVAprz5SDwEUoIDL1bLlOphVCs9gnptdWPadzBR7KbSrIbX31';
            $access_token = '831669493621350401-dWf8Z2kmMjHe4q6MnP3136pfImtaPI3';
            $access_token_secret = '7J9HYDfw9wVWuOsrHyJmouRAUoB5yV0IMLYNlnIT2KmWe';
            $connect = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
            define('TWEET_COUNT_PER_REQUEST', 100);
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
            $request_count = 0;
            $suffix = '_HOUR';
            $since = date('Y-m-d_H:i:00', strtotime('-1 hour')).'_JST';
            $until = date('Y-m-d_H:i:00').'_JST';
            foreach ($currency_names as $key => $value) {
                Log::debug('>>>>> This currency is ' . $key);
                $params = [
                    'q' => '#'.$key . ' OR ' . '#'.$value,
                    'lang' => 'ja',
                    'count' => TWEET_COUNT_PER_REQUEST,
                    'since' => $since,
                    'until' => $until,
                ];
                while (true) {
                    $tweets_response = $connect->get('search/tweets', $params);
                    if (property_exists($tweets_response, 'errors')) {
                        $errors = $tweets_response->errors;
                        // TwitterAPIの制限である180request/15minを超えた場合、エラーコード88が返ってくる
                        if ($errors[0]->code === 88) {
                            Log::debug('リクエスト数の上限に達したため、15分待機します。');
                            sleep(60*15);
                            continue;
                        } else {
                            Log::debug('予期しないエラーが発生したため、処理を終了します。');
                            exit;
                        }
                    }
                    // レスポンスオブジェクトからツイートオブジェクトを取得
                    $tweets_obj = $tweets_response->statuses;
                    // レスポンスオブジェクトからメタデータオブジェクトを取得
                    $search_metadata_obj = $tweets_response->search_metadata;

                    if (property_exists($search_metadata_obj, 'next_results')) {
                        foreach ($tweets_obj as $tweet) {
                            $tweet_count[$key] += 1;
                        }
                        $next_results = preg_replace('/^\?/', '', $search_metadata_obj->next_results);
                        parse_str($next_results, $params);
                    } else {
                        break;
                    }
                }
                Log::debug('>>>>> ' . $value . 'のツイート数は [' . $tweet_count[$key] . '] 件です。');
                $currency_code = $key . $suffix;
                $tweet_count_obj = TweetCount::where('currency_code', $currency_code)->first();
                if (empty($tweet_count_obj)) {
                    Log::debug('currency_codeが' . $currency_code . 'のデータは存在しません。新規登録します。');
                    TweetCount::create([
                        'currency_code' => $currency_code,
                        'count' => $tweet_count[$key],
                    ]);
                } else {
                    Log::debug('currency_codeが' . $currency_code . 'のデータは存在します。データを更新します。');
                    TweetCount::where('currency_code', $currency_code)->update(['count' => $tweet_count[$key]]);
                }
            }
        })->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
