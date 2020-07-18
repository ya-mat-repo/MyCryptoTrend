<template>
    <div class="c-base__container">
      <section class="p-hero">
        <!-- <p class="p-hero__title is-left">トレンドを</p> -->
        <p class="p-hero__title is-center">Be aware of trends!</p>
        <!-- <p class="p-hero__title is-right">掴む！</p> -->
      </section>
      <section class="c-container">
        <div class="c-container__text">
          <span class="p-message__item"><i class="fas fa-check p-icon__check"></i>投資に大切なのは、第一に情報！</span>
          <span class="p-message__item"><i class="fas fa-check p-icon__check"></i>貴方にあった、貴方だけの情報を、スピーディーに取得できる！</span>
          <span class="p-message__item"><i class="fas fa-check p-icon__check"></i>それが、仮想通貨トレンド収集サービス、Cripto Trend！</span>
        </div>
      </section>
      <section class="p-appeal__container">
        <!-- Point01 -->
        <div class="p-appeal is-left">
          <div class="p-image__container">
            <p class="p-appeal__title">Point<span class="is-red">01</span></p>
            <!-- <img class="p-appeal__image" src="{{ asset('img/business_item.jpg') }}" alt="No image"> -->
          </div>
          <div class="p-appeal__text">
            <!-- <img class="p-title__icon" src="{{ asset('img/icon-hanepen.png') }}" alt="No image"> -->
            <span class="p-text__title">トレンドを瞬時に把握できる！</span>
            <span class="p-appeal__message">
              Twitter上でのツイート数を自動で取得しツイート数の多い順に表示します。
              ツイート数のランキングを見ることで仮想通貨のトレンドの把握に役立ちます。
            </span>
            {{-- <span class="p-appeal__message">情報収集したい通貨を選べる！</span>
            <span class="p-appeal__message">発信元を自動でフォローできる！</span> --}}
          </div>
        </div>
        <!-- Point02 -->
        <div class="p-appeal is-right">
          <div class="p-image__container">
            <p class="p-appeal__title">Point<span class="is-red">02</span></p>
            <!-- <img class="p-appeal__image" src="{{ asset('img/twitter_title.jpg') }}" alt="No image"> -->
          </div>
          <div class="p-appeal__text">
            <!-- <img class="p-title__icon" src="{{ asset('img/icon-hanepen.png') }}" alt="No image"> -->
            <span class="p-text__title">Twitterアカウントをフォローできる！</span>
            <span class="p-appeal__message">
              仮想通貨というキーワードをユーザー名またはプロフィールに記載しているユーザーを
              一覧で表示し、その画面上からフォローすることができます。
              また、自動フォロー機能を使用することで一覧表示されているアカウントを自動でフォローできます。
            </span>
            {{-- <span class="p-appeal__message">情報収集したい通貨を選べる！</span>
            <span class="p-appeal__message">発信元を自動でフォローできる！</span> --}}
          </div>
        </div>
        <!-- Point03 -->
        <div class="p-appeal is-left">
          <div class="p-image__container">
            <p class="p-appeal__title">Point<span class="is-red">03</span></p>
            <!-- <img class="p-appeal__image" src="{{ asset('img/digital_life.jpg') }}" alt="No image"> -->
          </div>
          <div class="p-appeal__text">
            <!-- <img class="p-title__icon" src="{{ asset('img/icon-hanepen.png') }}" alt="No image"> -->
            <span class="p-text__title">ニュースを自動で収集できる！</span>
            <span class="p-appeal__message">
              Google Newsから「仮想通貨」というキーワードで自動で検索し、
              仮想通貨関連のニュースを一覧で表示します。
              自ら探す手間が省け、多忙な時でも大切な情報を逃しません！
            </span>
            {{-- <span class="p-appeal__message">情報収集したい通貨を選べる！</span>
            <span class="p-appeal__message">発信元を自動でフォローできる！</span> --}}
          </div>
        </div>
      </section>
      <!-- <div class="c-register__btn u-margin-top--100"><a href="/register">今すぐ無料で登録！</a></div> -->
    </div>
</template>

<script>
    export default {
        props: ['tweet_counts_json', 'ticker_response_json', 'count_updated_at'],
        data: function() {
            return {
                currencyName : {
                    "BTC" : "ビットコイン",
                    "ETH" : "イーサリアム",
                    "ETC" : "イーサリアムクラシック",
                    "LSK" : "リスク",
                    "FCT" : "ファクトム",
                    "XRP" : "リップル",
                    "XEM" : "ネム",
                    "LTC" : "ライトコイン",
                    "BCH" : "ビットコインキャッシュ",
                    "MONA" : "モナーコイン",
                    "XLM" : "ステラ・ルーメン",
                    "QTUM" : "クアンタム"
                },
                checkBtn : {
                    // "ALL" : true,
                    "BTC" : true,
                    "ETH" : true,
                    "ETC" : true,
                    "LSK" : true,
                    "FCT" : true,
                    "XRP" : true,
                    "XEM" : true,
                    "LTC" : true,
                    "BCH" : true,
                    "MONA" : true,
                    "XLM" : true,
                    "QTUM" : true
                },
                term: "DAY"
            }
        },
        methods: {
            selectAll : function() {
                const $that = this;
                Object.keys($that.checkBtn).forEach(function(key) {
                    $that.checkBtn[key] = true;
                });
            },
            cancelAll : function() {
                const $that = this;
                Object.keys($that.checkBtn).forEach(function(key) {
                    $that.checkBtn[key] = false;
                });
            }
        }
    }
</script>