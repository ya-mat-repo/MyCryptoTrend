<?php

namespace App\Http\Controllers;

use App\TweetCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        // コインチェックAPIを使ってティッカー情報を取得
        $coin_check_url = 'https://coincheck.com/api/ticker';
        $ticker_response_json = file_get_contents($coin_check_url);
        Log::debug('***** $ticker_response_json = ' . $ticker_response_json);

        // ===================
        // DB登録のテストコード
        // ===================
        // $currency_code = 'BTC_DAY';
        // $tweet_count_obj = TweetCount::where('currency_code', $currency_code)->first();
        // if (!empty($tweet_count_obj)) {
        //     // ini_set('memory_limit', '256M');
        //     Log::debug('currency_codeが' . $currency_code . 'のデータは存在します。');
        //     Log::debug('tweet_count_obj = ' . print_r($tweet_count_obj, true));
        //     // Log::debug('sizeof = ' . sizeof($tweet_count_obj));
        //     TweetCount::where('currency_code', $currency_code)->update(['count' => 4000]);
        //     // $tweet_count_obj->count = 3000;
        //     // $tweet_count_obj->save();
        // } else {
        //     Log::debug('currency_codeが' . $currency_code . 'のデータは存在しません。');
        //     TweetCount::create([
        //         'currency_code' => $currency_code,
        //         'count' => 9999,
        //     ]);
        // }
        // $BTC_DAY = TweetCount::where('currency_code', 'BTC_DAY')->first()->count;
        // Log::debug('$BTC_DAY = ' . $BTC_DAY);

        // whereは、where('カラム名','オペレーター','カラムに対して比較する値')で書けるみたい
        // e.g. $posts = News::where('title','like','%'.$cond_title.'%')->orderBy('created_at','desc')->paginate(5);
        
        // ツイッターの通貨別のツイート数をDBから取得する
        // $tweet_counts = TweetCount::all();

        // 時間、日、週ごとの更新日時を格納する配列
        $count_updated_at = [
            'HOUR' => '',
            'DAY' => '',
            'WEEK' => '',
        ];

        $tweet_counts = TweetCount::orderBy('count', 'desc')->get();
        // Log::debug('$tweet_counts = ' . print_r($tweet_counts, true));
        foreach ($tweet_counts as $tweet_count) {
            $temp_array = explode('_', $tweet_count->currency_code);
            $currency_code = $temp_array[0];
            $suffix = $temp_array[1];
            $tweet_counts_array[$tweet_count->currency_code] = [
                'currency_code' => $currency_code,
                'suffix' => $suffix,
                'count' => $tweet_count->count,
            ];
            if (empty($count_updated_at[$suffix])) {
                $count_updated_at[$suffix] = date('Y-m-d H:i', strtotime($tweet_count->updated_at));
            }
        }
        $tweet_counts_json = json_encode($tweet_counts_array);
        $count_updated_at = json_encode($count_updated_at);
        // Log::debug('$tweet_counts_json = ' . print_r($tweet_counts_json, true));
        // Log::debug('$count_updated_at = ' . print_r($count_updated_at, true));

        // 暗号化の実験
        // $test_message = '123hoge456mage###';
        // $test_message_encrypt = encrypt($test_message);
        // Log::debug('>>> $test_message_encrypt = ' . $test_message_encrypt);
        // $test_message_decrypt = decrypt($test_message_encrypt);
        // Log::debug('>>> $test_message_decrypt = ' . $test_message_decrypt);
        // $checkCrypt = ($test_message === $test_message_decrypt) ? 'OK' : 'NG';
        // Log::debug('>>> $checkCrypt = ' . $checkCrypt);



        return view('home', compact('tweet_counts_json', 'ticker_response_json', 'count_updated_at'));
    }
}
