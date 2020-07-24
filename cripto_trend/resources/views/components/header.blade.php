<header class="l-header js-float-menu">
    {{-- <h1 class="p-header__title"><a href="/">Crypto <br class="u-sp-break">Trend</a></h1> --}}
    <h1 class="p-header__title"><a href=" {{ url("/")}} ">Crypto Trend</a></h1>

    <!--   ハンバーガーメニューになる部分   -->
    <div class="c-menu__trigger js-toggle-sp-menu">
        <span></span>
        <span></span>
        <span></span>
    </div>
    
    <nav class="c-nav-menu js-toggle-sp-menu-target">
        <ul class="c-list__container">
            @auth
                {{-- <li class="c-list__item"><a class="c-header__menu" href=""></a></li> --}}
                <li class="c-list__item js-sp-menu-item"><a class="c-header__menu" href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="c-list__item js-sp-menu-item"><a class="c-header__menu" href="{{ route('twitter_auth') }}">{{ __('Twitter_auth') }}</a></li>
                <li class="c-list__item js-sp-menu-item"><a class="c-header__menu" href="{{ route('list') }}">{{ __('List') }}</a></li>
                <li class="c-list__item js-sp-menu-item"><a class="c-header__menu" href="{{ route('news') }}">{{ __('News') }}</a></li>
                <li class="c-list__item js-sp-menu-item"><a class="c-header__menu" href="{{ route('logout') }}">{{ __('Logout') }}</a></li>
            @else
                <li class="c-list__item js-sp-menu-item"><a class="c-header__menu" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                <li class="c-list__item js-sp-menu-item"><a class="c-header__menu" href="{{ route('register') }}">{{ __('Register') }}</a></li>
            @endauth
        </ul>
    </nav>
</header>
