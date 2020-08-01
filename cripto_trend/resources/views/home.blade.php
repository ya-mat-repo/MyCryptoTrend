<!doctype html>
@component('components.head')
    @slot('title')
        トレンド | 各仮想通貨のツイート数
    @endslot
    @slot('description')
        仮想通貨情報収集サービス「Crypto Trend」の仮想通貨のトレンド確認用ページです。
        仮想通貨ごとのツイート数を比較することでトレンドの把握に役立ちます。
    @endslot
    @slot('keywords')
        Crypto Trend,トレンド,ツイート数,仮想通貨
    @endslot
@endcomponent
<body>
    @component('components.header')
    @endcomponent

    <main>
        <div id="app">
            <show-trend-component :tweet_counts_json="{{$tweet_counts_json}}" :ticker_response_json="{{$ticker_response_json}}" :count_updated_at="{{$count_updated_at}}"></show-trend-component>
        </div>
    </main>

    @component('components.footer')
    @endcomponent

</body>
</html>  