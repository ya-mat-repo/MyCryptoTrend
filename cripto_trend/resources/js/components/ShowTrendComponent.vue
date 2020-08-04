<template>
    <div class="c-background__container">
        <div class="c-home__container">
            <div class="c-checkbox__area">
                <div class="c-select-currency">
                    <h2 class="c-select-currency__title">通貨を選択</h2>
                    <button @click="selectAll" class="c-button__select is-all">全て選択</button>
                    <button @click="cancelAll" class="c-button__select is-cancel">全て解除</button>
                    <div v-for="(value, key) in currencyName" class="c-checkbox__container" :key="key">
                        <!-- <input v-model="checkBtn[key]" type="checkbox" class="c-checkbox__item" value="key"><span class="c-checkbox__label">{{value}}<br class="u-sp-break">({{key}})</span> -->
                        <input v-model="checkBtn[key]" type="checkbox" class="c-checkbox__item" value="key"><span class="c-checkbox__label">{{value}}({{key}})</span>
                    </div>
                </div>
            </div>
            <div class="c-trend-ranking">
                <div class="c-term">
                    <div class="c-term__container">
                        <label for="term-select">
                            <h2 class="c-term__title">集計期間</h2>
                        </label>
                        <div class="c-term__select">
                            <select v-model="term" class="c-selectbox__area">
                                <option value="HOUR">過去１時間</option>
                                <option value="DAY" selected>過去１日</option>
                                <option value="WEEK">過去１週間</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="c-currency__container">
                    <div class="c-time">
                        <span class="c-time__label">
                            <span class="u-font-size--s">(＊)</span>
                            {{count_updated_at[term]}} 時点
                        </span>
                    </div>
                    <table class="c-currency-table">
                        <thead>
                            <tr class="c-currency-table__header">
                                <th class="c-currency-table__title is-width-fix">銘柄名</th>
                                <th class="c-currency-table__title">ツイート数<span class="u-font-size--s">(＊)</span></th>
                                <th class="c-currency-table__title"><span class="u-font-size--s">24時間での</span>最高取引価格</th>
                                <th class="c-currency-table__title"><span class="u-font-size--s">24時間での</span>最低取引価格</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(tweet_count, key) in tweet_counts_json">
                                <template v-if="tweet_count['suffix'] === term && checkBtn[tweet_count['currency_code']]">
                                    <tr class="c-currency-table__row" :key="key">
                                        <td class="c-currency-table__data u-text-center"><a href="https://twitter.com/home" target="_blank">{{currencyName[tweet_count['currency_code']]}}</a></td>
                                        <td class="c-currency-table__data u-text-right">{{ Number(tweet_count['count']).toLocaleString() }}</td>
                                        <template v-if="tweet_count['currency_code'] === 'BTC'">
                                            <td class="c-currency-table__data u-text-right">{{ Number(ticker_response_json['high']).toLocaleString() }}</td>
                                            <td class="c-currency-table__data u-text-right">{{ Number(ticker_response_json['low']).toLocaleString() }}</td>
                                        </template>
                                        <template v-else>
                                            <td class="c-currency-table__data u-text-right">不明</td>
                                            <td class="c-currency-table__data u-text-right">不明</td>
                                        </template>
                                    </tr>
                                </template>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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