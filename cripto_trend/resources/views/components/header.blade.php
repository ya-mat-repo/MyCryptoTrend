<header>
  <nav class="l-header is-relative">
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
