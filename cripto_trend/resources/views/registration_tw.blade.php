<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register Twitter Account | Cripto Trend</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
</head>
<body>
    <header>
        <nav class="l-header is-relative">
            <h1 class="p-header__title"><a href="/">Cripto Trend</a></h1>
            <ul class="l-list__container">
                @auth
                    <li class="l-list__item"><a class="c-header__menu" href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="l-list__item"><a class="c-header__menu" href="{{ route('list') }}">{{ __('List') }}</a></li>
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
        {{-- <div id="app">
            <register-twitter-account-component></register-twitter-account-component>
        </div> --}}
        <div class="c-register-twitter__container">
            <div class="c-register-twitter-form">
                <form method="POST" action="/registration_tw">
                    @csrf
                    <h2 class="c-register-twitter-form__label">Twitterアカウント{{$type_name}}</h2>
                    <input class="c-register-twitter-form__input" type="text" name="twitterAccount" placeholder="TwitterのログインIDを入力">
                    <button type="submit" class="c-register-twitter-form__submit" name="submit">{{$type_name}}</button>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <div class="l-footer">
            ©️ 2020 Yasunori Matsuoka
        </div>
    </footer>
    {{-- Scripts --}}
    <script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>  