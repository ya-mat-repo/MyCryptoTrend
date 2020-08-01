<!doctype html>
@component('components.head')
    @slot('title')
        パスワード再設定 | 案内メール送信
    @endslot
    @slot('description')
        仮想通貨情報収集サービス「Crypto Trend」のパスワード再設定用ページです。
        ご入力いただいたメールアドレス宛にパスワード再設定の案内メールをお送りします。
    @endslot
    @slot('keywords')
        Crypto Trend,パスワード,再設定,案内,メール,メールアドレス
    @endslot
@endcomponent

    <body>
        @component('components.header')
        @endcomponent

        <div id="app">
            <div class="c-remainder__container">
                <form method="POST" action="{{ route('password.email') }}" class="c-remainder__form">
                    @csrf

                    <p class="c-remainder__title">パスワード再設定</p>
                    <div class="c-remainder">
                        <label for="email" class="c-remainder__label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="c-remainder__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="u-invalid--error is-email-reset" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="c-remainder__submit">
                        <button type="submit" class="u-btn__submit">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
            @if (session('status'))
                <div class="c-remainder__message">
                    {{ session('status') }}
                </div>
            @endif

        </div>
        
        @component('components.footer')
        @endcomponent

    </body>
</html>