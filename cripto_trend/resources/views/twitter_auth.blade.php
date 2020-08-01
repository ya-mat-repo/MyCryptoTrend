<!doctype html>
@component('components.head')
    @slot('title')
        Twitterアカウント認証
    @endslot
    @slot('description')
        仮想通貨情報収集サービス「Crypto Trend」のTwitterアカウント認証用ページです。
        本ページからTwitterアカウントの認証を行うことで自動フォロー機能や
        手動でのアカウントのフォローが可能になります。
    @endslot
    @slot('keywords')
        Crypto Trend,アカウント,認証,Twitter,自動フォロー,フォロー
    @endslot
@endcomponent
<body>
    @component('components.header')
    @endcomponent

    <div id="app">
        <main>
            <div class="c-twitter-auth">
                @if (session()->has('flash_message'))
                    <div class="c-flash-message js-flash_message">
                        <h2 class="c-flash-message__text">{{session('flash_message')}}</h2>
                    </div>
                @endif

                <div class="c-twitter-auth__information">
                    <h2 class="c-twitter-auth__information--title">Twitterアカウントの認証</h2>
                    Twitterアカウントの認証を行うことで、アカウント一覧画面から他のTwitterアカウントをフォローすることができます。
                    また、Twitterアカウントの自動フォロー機能を使うためにも事前にTwitterアカウントの認証が必要です。
                    認証を行う場合は以下の「認証する」をクリックしてください。(認証できるTwitterアカウントは1つです。)
                </div>
                @if ($is_twitter_auth)
                    <button class="c-twitter-auth__submit is-auth" name="submit">認証済み</button>
                @else
                    <button class="c-twitter-auth__submit" name="submit"><a class="c-twitter-auth__link" href="{{route('get_request_token')}}">認証する</a></button>
                @endif
            </div>

        </main>
    </div>

    @component('components.footer')
    @endcomponent

</body>
</html>  