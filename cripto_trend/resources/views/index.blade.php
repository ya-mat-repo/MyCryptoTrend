<!doctype html>
    @component('components.head')
        Top
    @endcomponent

    <body>
        <header>
            <nav class="l-header">
                <h1 class="p-header__title"><a href="/">Cripto Trend</a></h1>
                <ul class="l-list__container">
                    @auth
                        <li class="l-list__item"><a class="c-header__menu" href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li class="l-list__item"><a class="c-header__menu" href="{{ route('list') }}">{{ __('List') }}</a></li>
                        <li class="l-list__item"><a class="c-header__menu" href="{{ route('twitter_auth') }}">{{ __('Twitter_auth') }}</a></li>
                        <li class="l-list__item"><a class="c-header__menu" href="{{ route('news') }}">{{ __('News') }}</a></li>
                        <li class="l-list__item"><a class="c-header__menu" href="{{ route('logout') }}">{{ __('Logout') }}</a></li>
                    @else
                        <li class="l-list__item"><a class="c-header__menu" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li class="l-list__item"><a class="c-header__menu" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @endauth
                </ul>
            </nav>
        </header>
        <main>
            <section class="p-hero">
                <!-- <p class="p-hero__title is-left">トレンドを</p> -->
                <p class="p-hero__title is-center">Be aware of trends!</p>
                <!-- <p class="p-hero__title is-right">掴む！</p> -->
            </section>
            <section class="c-container">
                <div class="c-container__text">
                <span class="p-message__item"><i class="fas fa-check p-icon__check"></i>投資に大切なのは、第一に情報！</span>
                <span class="p-message__item"><i class="fas fa-check p-icon__check"></i>貴方にあった、貴方だけの情報を、スピーディーに取得できる！</span>
                <span class="p-message__item"><i class="fas fa-check p-icon__check"></i>それが、仮想通貨トレンド収集サービス、Cripto Trend！</span>
                </div>
            </section>
            <section class="p-appeal__container">
                <!-- Point01 -->
                <div class="p-appeal is-left">
                <div class="p-image__container">
                    <p class="p-appeal__title">Point<span class="is-red">01</span></p>
                    <img class="p-appeal__image" src="{{ asset('img/business_item.jpg') }}" alt="No image">
                </div>
                <div class="p-appeal__text">
                    <img class="p-title__icon" src="{{ asset('img/icon-hanepen.png') }}" alt="No image">
                    <span class="p-text__title">トレンドを瞬時に把握できる！</span>
                    <span class="p-appeal__message">
                    Twitter上でのツイート数を自動で取得しツイート数の多い順に表示します。
                    ツイート数のランキングを見ることで仮想通貨のトレンドの把握に役立ちます。
                    </span>
                    {{-- <span class="p-appeal__message">情報収集したい通貨を選べる！</span>
                    <span class="p-appeal__message">発信元を自動でフォローできる！</span> --}}
                </div>
                </div>
                <!-- Point02 -->
                <div class="p-appeal is-right">
                <div class="p-image__container">
                    <p class="p-appeal__title">Point<span class="is-red">02</span></p>
                    <img class="p-appeal__image" src="{{ asset('img/twitter_title.jpg') }}" alt="No image">
                </div>
                <div class="p-appeal__text">
                    <img class="p-title__icon" src="{{ asset('img/icon-hanepen.png') }}" alt="No image">
                    <span class="p-text__title">Twitterアカウントをフォローできる！</span>
                    <span class="p-appeal__message">
                    仮想通貨というキーワードをユーザー名またはプロフィールに記載しているユーザーを
                    一覧で表示し、その画面上からフォローすることができます。
                    また、自動フォロー機能を使用することで一覧表示されているアカウントを自動でフォローできます。
                    </span>
                    {{-- <span class="p-appeal__message">情報収集したい通貨を選べる！</span>
                    <span class="p-appeal__message">発信元を自動でフォローできる！</span> --}}
                </div>
                </div>
                <!-- Point03 -->
                <div class="p-appeal is-left">
                <div class="p-image__container">
                    <p class="p-appeal__title">Point<span class="is-red">03</span></p>
                    <img class="p-appeal__image" src="{{ asset('img/digital_life.jpg') }}" alt="No image">
                </div>
                <div class="p-appeal__text">
                    <img class="p-title__icon" src="{{ asset('img/icon-hanepen.png') }}" alt="No image">
                    <span class="p-text__title">ニュースを自動で収集できる！</span>
                    <span class="p-appeal__message">
                    Google Newsから「仮想通貨」というキーワードで自動で検索し、
                    仮想通貨関連のニュースを一覧で表示します。
                    自ら探す手間が省け、多忙な時でも大切な情報を逃しません！
                    </span>
                    {{-- <span class="p-appeal__message">情報収集したい通貨を選べる！</span>
                    <span class="p-appeal__message">発信元を自動でフォローできる！</span> --}}
                </div>
                </div>
            </section>
            <div class="c-register__btn u-margin-top--100"><a href="/register">今すぐ無料で登録！</a></div>
            <div id="app">
                {{-- <index-component></index-component> --}}
            </div>
        </main>

        @component('components.footer')
        @endcomponent

    </body>
</html>  