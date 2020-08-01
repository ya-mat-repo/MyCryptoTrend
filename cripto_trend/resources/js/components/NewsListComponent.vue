<template>
    <div>
        <div class="c-news__container">
            <div class="c-news__header">
                <h1 class="c-news__label">「仮想通貨」関連ニュース一覧</h1>
                <div class="c-news-page">
                    <button class="c-news-page__label c-news-page__button" @click="prevPage">前のページへ</button>
                    <button class="c-news-page__label c-news-page__button" @click="nextPage">次のページへ</button>
                    <div class="c-news-page__label">[{{page}} / {{maxPageNum}}]</div>
                </div>
            </div>

            <div class="c-news__item">
                <ul>
                    <li v-for="(content, index) in displayContents" :key=index>
                        <span class="c-news__item--pubdate">{{dateFormat(content.pubDate)}}</span>
                        <a :href="content.link" target="_blank">
                            <textarea class="c-news__item--title" cols="100" rows="1" readonly v-model="content['title']"></textarea>
                            <!-- <textarea class="c-news__item--title" cols="100" rows="1" readonly v-model="content['title']">{{content.title}}</textarea> -->
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['contents_json'],
        data: function() {
            return {
                minPageNum: 1,  // 最小ページ数
                perPage: 15,    // 1ページあたりの表示件数
                page: 1         // 表示ページ番号
            }
        },
        computed: {
            maxPageNum: function() {
                const contentsSize = Object.keys(this.contents_json).length;
                return Math.ceil(contentsSize / this.perPage);
            },
            displayContents: function() {
                let contents = [];
                // let displayContents = this.contents;
                let more = (this.page - 1) * this.perPage;
                let less = (this.page * this.perPage) - 1;
                // console.log('more = ' + more);
                // console.log('less = ' + less);
                for (let key of this.contents_json.keys()) {
                    if (key > less) {
                        break;
                    }
                    if (key >= more) {
                        // console.log(key + ':' + this.contents_json[key]['title']);
                        contents[key] = this.contents_json[key];
                        // console.dir(contents[key]);
                    }
                }
                for (let i = 0; i < more; i++) {
                    contents.shift();
                }
                return contents;
            },

        },
        methods: {
            prevPage: function() {
                this.page -= 1;
                if (this.page < this.minPageNum) {
                    this.page = this.minPageNum;
                }
                return this.page;
            },
            nextPage: function() {
                this.page += 1;
                if (this.page > this.maxPageNum) {
                    this.page = this.maxPageNum;
                }
                return this.page;
            },
            dateFormat(dateStr) {
                let dateMilliSeconds = Date.parse(dateStr);
                let date = new Date(dateMilliSeconds);
                let year = date.getFullYear();
                let month = date.getMonth() + 1;
                month = ('0' + month).slice(-2);
                let day = date.getDate();
                day = ('0' + day).slice(-2);
                let hour = date.getHours();
                hour = ('0' + hour).slice(-2);
                let minutes = date.getMinutes();
                minutes = ('0' + minutes).slice(-2);
                let seconds = date.getSeconds();
                seconds = ('0' + seconds).slice(-2);
                let formatedDate = year + '/' + month + '/' + day + ' ' + hour + ':' + minutes + ':' + seconds + '_JST';
                return formatedDate;
            }
        }
    }
</script>