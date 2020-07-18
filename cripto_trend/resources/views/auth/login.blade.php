<!doctype html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Cripto Trend</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head> --}}
    @component('components.head')
        Login
    @endcomponent

    <body>
        <header>
            <nav class="l-header">
            <h1 class="p-header__title"><a href="/">Cripto Trend</a></h1>
                <ul class="l-list__container">
                    <li class="l-list__item"><a class="c-header__menu" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li class="l-list__item"><a class="c-header__menu" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                </ul>
            </nav>
        </header>
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
        <footer>
            <div class="l-footer">
                ©️ 2020 Yasunori Matsuoka
            </div>
        </footer>
  </body>
</html>