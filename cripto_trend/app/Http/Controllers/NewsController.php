<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Google News一覧表示用のコントローラー
    |--------------------------------------------------------------------------
    */
    public function news() {
        $BASE_URL = 'https://news.google.com/rss/search?';
        $keyword = '仮想通貨';
        $params = [
            'q' => $keyword,
            'hl' => 'ja',
            'gl' => 'JP',
            'ceid' => 'JP:ja',
        ];
        $API_URI = $BASE_URL . http_build_query($params);
        Log::debug('$API_URI = ' . $API_URI);
        $contents_xml = file_get_contents($API_URI);
        $contents_obj = json_encode(simplexml_load_string($contents_xml));

        $contents_array = json_decode($contents_obj, true);
        
        $contents_channel_item = $contents_array['channel']['item'];

        Log::debug('=====> [' . count($contents_channel_item) . '] 件のニュースを取得しました。');
        $contents_json = json_encode($contents_channel_item, JSON_UNESCAPED_UNICODE);

        return view('news', compact('contents_json'));
    }
}
