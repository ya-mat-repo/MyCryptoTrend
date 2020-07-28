<!doctype html>
    @component('components.head')
        Reset
    @endcomponent

    <body>
        @component('components.header')
        @endcomponent

        <div id="app">
            <div class="c-remainder__container">
                @if (session('status'))
                    <div class="c-flash-message" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="c-remainder__form">
                    @csrf

                    <p class="c-remainder__title">パスワード再設定</p>
                    <div class="c-remainder">
                        <label for="email" class="c-remainder__label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="c-remainder__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="u-invalid--error" role="alert">
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
        </div>
        
        @component('components.footer')
        @endcomponent

    </body>
</html>