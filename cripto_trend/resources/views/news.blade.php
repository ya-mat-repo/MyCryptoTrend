<!doctype html>

@component('components.head')
    News
@endcomponent

<body>

    @component('components.header_relative')
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