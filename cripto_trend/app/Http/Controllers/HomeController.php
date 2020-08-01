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

        // 時間、日、週ごとの更新日時を格納する配列
        $count_updated_at = [
            'HOUR' => '',
            'DAY' => '',
            'WEEK' => '',
        ];

        $tweet_counts = TweetCount::orderBy('count', 'desc')->get();
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

        return view('home', compact('tweet_counts_json', 'ticker_response_json', 'count_updated_at'));
    }
}
