<!doctype html>
    @component('components.head')
        @slot('title')
            Crypto Trendのご紹介
        @endslot
        @slot('description')
            仮想通貨情報収集サービス「Crypto Trend」のトップページです。
            「Crypto Trend」では、Twitterアカウントと連携した仮想通貨関連アカウントの自動フォローや
            Google Newsから仮想通貨関連のニュースを取得し一覧で表示するサービスを提供しています。
        @endslot
        @slot('keywords')
            Crypto Trend,ご紹介,自動フォロー,Twitter,仮想通貨,ニュース,Google News
        @endslot
    @endcomponent

    <body>
        @component('components.header')
        @endcomponent

        <div id="app">
            <main>
                <section class="p-hero js-float-menu-target">
                    <p class="p-hero__title is-center">Be aware of trends!</p>
                </section>
                <section class="c-strength-container">
                    <p class="c-strength-container__label">Crypto Trendのメリット</p>
                    <div class="c-strength-container__text">
                        <span class="p-message__item"><i class="fas fa-check p-icon__check"></i>ツイート数の比較でトレンドが瞬時に分かる！</span>
                        <span class="p-message__item"><i class="fas fa-check p-icon__check"></i>自動フォロー機能によりフォローの手間が省ける！</span>
                        <span class="p-message__item"><i class="fas fa-check p-icon__check"></i>仮想通貨関連のニュースを即座にチェックできる！</span>
                    </div>
                </section>
                <section class="p-appeal__container">
                    <!-- Point01 -->
                    <div class="p-appeal is-left">
                    <div class="p-image__container">
                        <p class="p-appeal__title">Point<span class="is-red">01</span></p>
                        <img class="p-appeal__image" src="{{ asset('img/business_item_m.jpg') }}" alt="No image">
                    </div>
                    <div class="p-appeal__text">
                        <img class="p-title__icon" src="{{ asset('img/icon-hanepen.png') }}" alt="No image">
                        <span class="p-text__title">トレンドを瞬時に把握できる！</span>
                        <span class="p-appeal__message">
                        Twitter上での仮想通貨ごとのツイート数を自動で取得し、ツイート数の多い順に表示します。
                        ツイート数を比較することで仮想通貨のトレンドを瞬時に把握できます。
                        </span>
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
                        <span class="p-text__title">Twitterアカウントを自動でフォロー！</span>
                        <span class="p-appeal__message">
                        仮想通貨というキーワードをユーザー名またはプロフィールに記載しているユーザーを
                        一覧で表示し、画面上からフォローすることができます。
                        また、自動フォロー機能を使用することで一覧表示されているアカウントを自動でフォローできます。
                        </span>
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
                        <span class="p-text__title">ニュースを自動で収集！</span>
                        <span class="p-appeal__message">
                        Google Newsから「仮想通貨」というキーワードで自動で検索し、
                        仮想通貨関連のニュースを一覧で表示します。
                        自ら探す手間が省け、多忙な時でも大切な情報を逃しません！
                        </span>
                    </div>
                    </div>
                </section>
                @if (!Auth::check())
                    <div class="c-register__btn"><a class="c-register__link" href="{{ url("/register") }}">今すぐ無料で登録！</a></div>
                @endif
            </main>
        </div>

        @component('components.footer')
        @endcomponent

    </body>
</html>  