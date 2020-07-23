<!doctype html>
    @component('components.head')
        Login
    @endcomponent

    <body>
        @component('components.header')
        @endcomponent
        
        <div id="app">
            <section class="c-background__login">
                <div class="c-login__container">
                    @error('email')
                        <span class="u-invalid--error" role="alert">
                            <span>{{ $message }}</span>
                        </span>
                    @enderror

                    <div class="c-item__container">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <p class="c-login__title">ログイン画面</p>
                            <div class="c-input__container">
                                <label for="email" class="c-login__label">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="c-login__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                
                            </div>
                        
                            <div class="c-input__container">
                                <label for="password" class="c-login__label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="c-login__input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            
                                @error('password')
                                <span class="u-invalid--error" role="alert">
                                    <span>{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        
                            <div class="c-remember">
                                <input class="c-remember__checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="c-remember__label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            <div class="c-submit">
                                <button type="submit" class="u-btn__login">
                                    {{ __('Login') }}
                                </button>
                            
                                @if (Route::has('password.request'))
                                    <a class="c-label__forgot" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        @component('components.footer')
        @endcomponent

  </body>
</html>