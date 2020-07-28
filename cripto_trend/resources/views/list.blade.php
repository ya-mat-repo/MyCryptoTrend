<!doctype html>
@component('components.head')
    Account List
@endcomponent
<body>
    @component('components.header')
    @endcomponent

    <main>
        @if (session()->has('flash_message'))
            <div class="c-flash-message js-flash_message">
                <h2 class="c-flash-message__text">{{session('flash_message')}}</h2>
            </div>
        @endif

        <div id="app">
        <account-list-component :candidates_json="{{json_encode($candidates)}}" is_twitter_auth="{{ $is_twitter_auth }}" is_auto_follow="{{ $is_auto_follow }}"></account-list-component>
        </div>
        {{ $candidates->links() }}

    </main>

    @component('components.footer')
    @endcomponent

</body>
</html>  