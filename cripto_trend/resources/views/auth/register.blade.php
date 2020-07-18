<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @component('components.head')
        Register
    @endcomponent

  <body>

    <header>
      <nav class="l-header">
      {{-- <nav class="l-header is-absolute"> --}}
          <h1 class="p-header__title"><a href="/">Cripto Trend</a></h1>
          <ul class="l-list__container">
              @auth
                  <li class="l-list__item"><a class="c-header__menu" href="{{ route('home') }}">{{ __('Home') }}</a></li>
                  <li class="l-list__item"><a class="c-header__menu" href="{{ route('twitter_auth') }}">{{ __('Twitter_auth') }}</a></li>
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

    <section class="c-background__login">
      <div class="c-login__container">
        <div class="c-item__container">
          <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <p class="c-login__title">新規登録画面</p>
            <div class="c-input__container">
              <label for="name" class="c-login__label">{{ __('Name') }}</label>
              <input id="name" type="text" class="c-login__input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
              
              @error('name')
              <span class="u-invalid--error" role="alert">
                <span>{{ $message }}</span>
              </span>
              @enderror
            </div>

            <div class="c-input__container">
              <label for="email" class="c-login__label">{{ __('E-Mail Address') }}</label>
              <input id="email" type="email" class="c-login__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              
              @error('email')
              <span class="u-invalid--error" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            
            <div class="c-input__container">
              <label for="password" class="c-login__label">{{ __('Password') }}</label>
              <input id="password" type="password" class="c-login__input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
              
              @error('password')
              <span class="u-invalid--error" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="c-input__container">
              <label for="password-confirm" class="c-login__label">{{ __('Confirm Password') }}</label>
              <input id="password-confirm" type="password" class="c-login__input" name="password_confirmation" required autocomplete="new-password">
            </div>
            
            <div class="c-submit">
              <button type="submit" class="u-btn__login">
                {{ __('Register') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>

    @component('components.footer')
    @endcomponent

  </body>
</html>