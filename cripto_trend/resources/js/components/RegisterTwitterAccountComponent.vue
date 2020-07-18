<template>
    <div class="c-register-twitter__container">
        <div class="c-register-twitter-form">
            <form method="POST" action="/registration_tw">
                <h2 class="c-register-twitter-form__label">Twitterアカウント登録</h2>
                <input class="c-register-twitter-form__input" type="text" name="twitterAccount" placeholder="ツイッターアカウントを入力">
                <button type="submit" class="c-register-twitter-form__submit" name="submit">登録</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: [],
        data: function() {
            return {
            }
        },
        methods: {
        }
    }
</script>