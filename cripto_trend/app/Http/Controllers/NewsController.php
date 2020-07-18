<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
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
        // Log::debug('$contents_xml'. print_r($contents_xml, true));
        // $contents_obj = simplexml_load_string($contents_xml);
        $contents_obj = json_encode(simplexml_load_string($contents_xml));
        // Log::debug('$contents_obj = '. print_r($contents_obj, true));

        $contents_array = json_decode($contents_obj, true);
        // Log::debug('$contents_array = '. print_r($contents_array, true));
        
        // $contents_channel_item = $contents_array->channel->item;
        $contents_channel_item = $contents_array['channel']['item'];
        // Log::debug('$contents_channel_item = '. print_r($contents_channel_item, true));

        // $contents_array = $contents_obj->channel->item;
        // Log::debug('$contents_array = '. print_r($contents_array, true));
        // $contents_array_item = $contents_array->item;
        // Log::debug('$contents_array_item = '. print_r($contents_array_item, true));
        // foreach ($contents_array as $key => $content) {
        //     Log::debug('$key = ' . $key);
        //     Log::debug('$content->title = ' . $content->title);
        //     Log::debug('$content->link = ' . $content->link);
        // }
        // $contents = [];
        // $index = 0;
        // foreach ($contents_array as $content) {
        //     $contents[$index] = [
        //         'title' => $content->title[0],
        //         'link' => $content->link[0],
        //     ];
        //     $index += 1;
        // }
        // Log::debug('$contents = ' . print_r($contents, true));
        Log::debug('=====> [' . count($contents_channel_item) . '] 件のニュースを取得しました。');
        $contents_json = json_encode($contents_channel_item, JSON_UNESCAPED_UNICODE);
        // Log::debug('$contents_json = '. print_r($contents_json, true));

        return view('news', compact('contents_json'));
    }
}
