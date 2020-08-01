<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@component('components.head')
  @slot('title')
      新規登録
  @endslot
  @slot('description')
      仮想通貨情報収集サービス「Crypto Trend」の新規登録用ページです。
  @endslot
  @slot('keywords')
      Crypto Trend,新規登録
  @endslot
@endcomponent

  <body>

    @component('components.header')
    @endcomponent

    <div id="app">
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
                <span class="u-invalid--error is-register" role="alert">
                  <span>{{ $message }}</span>
                </span>
                @enderror
              </div>

              <div class="c-input__container">
                <label for="email" class="c-login__label">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="c-login__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                
                @error('email')
                <span class="u-invalid--error is-register" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <span class="c-message__validate">{{ __('E-Mail Format') }}</span>
              
              <div class="c-input__container">
                <label for="password" class="c-login__label">{{ __('Password') }}</label>
                <input id="password" type="password" class="c-login__input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                
                @error('password')
                <span class="u-invalid--error is-register" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <span class="c-message__validate">{{ __('Password Format') }}</span>

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
    </div>
    @component('components.footer')
    @endcomponent

  </body>
</html>