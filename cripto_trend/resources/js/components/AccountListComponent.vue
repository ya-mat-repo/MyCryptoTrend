<template>
    <div class="c-account-list__container">
        <form method="POST" action="auto_follow" class="c-auto-follow">
            <input type="hidden" :value="csrfToken" name="_token"/>
            <span class="c-auto-follow__label">自動フォロー：</span>
            <template v-if="is_twitter_auth">
                <template v-if="is_auto_follow === '1'">
                    <button type="submit" class="c-auto-follow__submit to-disable" name="is_enable" value="disable">無効にする</button>
                </template>
                <template v-else>
                    <button type="submit" class="c-auto-follow__submit to-enable" name="is_enable" value="enable">有効にする</button>
                </template>
            </template>
            <template v-else>
                <form action="twitter_auth" method="GET">
                    <input type="hidden" :value="csrfToken" name="_token"/>
                    <button class="c-button__follow" type="submit">認証する</button>
                </form>
            </template>
        </form>

        <table class="c-account-table">
            <thead>
                <tr class="c-account-table__header">
                    <th class="c-account-table__title">ユーザー名</th>
                    <th class="c-account-table__title">アカウント名</th>
                    <th class="c-account-table__title">ﾌｫﾛｰ数</th>
                    <th class="c-account-table__title">ﾌｫﾛﾜｰ数</th>
                    <th class="c-account-table__title">プロフィール</th>
                    <th class="c-account-table__title">最新ツイート</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="(account, key) in  candidates_json['data']">
                    <tr class="c-account-table__row" :key="key">
                        <td class="c-account-table__data is-user-name">{{account['twitter_user_name']}}</td>
                        <td class="c-account-table__data"><textarea class="c-account-table__textarea" cols="20" rows="3" v-model="account['twitter_account_name']" readonly></textarea></td>
                        <td class="c-account-table__data is-right">{{Number(account['follows_count']).toLocaleString()}}</td>
                        <td class="c-account-table__data is-right">{{Number(account['followers_count']).toLocaleString()}}</td>
                        <td class="c-account-table__data"><textarea class="c-account-table__textarea" cols="30" rows="3" v-model="account['profile']" readonly></textarea></td>
                        <td class="c-account-table__data"><textarea class="c-account-table__textarea" cols="30" rows="3" v-model="account['latest_tweet']" readonly></textarea></td>
                        <td class="c-account-table__data">
                            <template v-if="is_twitter_auth">
                                <template v-if="account['is_follow_flag']">
                                    <form action="unfollow_account" method="POST">
                                        <input type="hidden" :value="csrfToken" name="_token"/>
                                        <input type="hidden" name="targetId" :value="account['id']"/>
                                        <input type="hidden" name="targetAccount" :value="account['twitter_user_name']"/>
                                        <button class="c-button__unfollow" type="submit" name="targetId" :value="account['id']">フォロー解除</button>
                                    </form>
                                </template>
                                <template v-else>
                                    <form action="follow_account" method="POST">
                                        <input type="hidden" :value="csrfToken" name="_token"/>
                                        <input type="hidden" name="targetId" :value="account['id']"/>
                                        <input type="hidden" name="targetAccount" :value="account['twitter_user_name']"/>
                                        <button class="c-button__follow" type="submit">フォローする</button>
                                    </form>
                                </template>
                            </template>
                            <template v-else>
                                <form action="twitter_auth" method="GET">
                                    <input type="hidden" :value="csrfToken" name="_token"/>
                                    <button class="c-button__follow" type="submit">認証する</button>
                                </form>
                            </template>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['candidates_json', 'is_twitter_auth', 'is_auto_follow'],
        data: function() {
            return {
                csrfToken: null,
            }
        },
        methods: {
        },
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        }
    }
</script>