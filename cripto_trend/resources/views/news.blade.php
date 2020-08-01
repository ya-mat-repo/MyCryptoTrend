<!doctype html>
@component('components.head')
    @slot('title')
        仮想通貨関連ニュース
    @endslot
    @slot('description')
        仮想通貨情報収集サービス「Crypto Trend」のニュース参照用ページです。
        Google Newsから仮想通貨関連のニュースを取得し表示しています。
    @endslot
    @slot('keywords')
        Crypto Trend,ニュース,Google News
    @endslot
@endcomponent
<body>

    @component('components.header')
    @endcomponent

    <main>
        <div id="app">
        <news-list-component :contents_json="{{$contents_json}}"></news-list-component>
        </div>
    </main>

    @component('components.footer')
    @endcomponent

</body>
</html>  