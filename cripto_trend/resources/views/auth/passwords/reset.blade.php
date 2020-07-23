<!doctype html>
    @component('components.head')
        Reset
    @endcomponent

    <body>
        @component('components.header_relative')
        @endcomponent

        <div id="app">
            <div class="c-reset__container">
                <form method="POST" action="{{ route('password.update') }}" class="c-reset__form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <p class="c-reset__title">パスワード再設定</p>
                    <div class="c-reset">
                        <div class="c-reset__input-block">
                            {{-- メールアドレス入力欄 --}}
                            <label for="email" class="c-reset__label">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="c-reset__input @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="c-reset--error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="c-reset__input-block">
                            {{-- パスワード入力欄 --}}
                            <label for="password" class="c-reset__label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="c-reset__input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="c-reset--error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="c-reset__input-block">
                            <label for="password-confirm" class="c-reset__label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="c-reset__input" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="c-reset__submit">
                        <button type="submit" class="u-btn__submit">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @component('components.footer')
        @endcomponent

    </body>
</html>
