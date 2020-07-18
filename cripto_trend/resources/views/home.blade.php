<!doctype html>
    @component('components.head')
        Home
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