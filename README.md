# MyCryptoTrendとは
仮想通貨関連の情報収集支援サービス

# 修正手順
githubからコードをpullする
1. $ git pull https://github.com/restfulrhino/MyCryptoTrend
2. pullしたコードをMAMPのhtdocsの下に配置する　（artisan serveで動かすからMAMPいらないかな）
3. artisanが入っているフォルダに移動して以下のコマンドを実行する
 　$ composer install (Package manifest generated successfully.と表示されれば成功)
　   →githubからpullした状態だとgitの管理対象外のファイルとかフォルダがあるからそれらを再度インストールする必要がある
4. http://127.0.0.1にアクセスしてNo application encryption key has been specified.になったら、、、
   .envにAPP_KEYが設定されていないのが原因。.env.prodのAPP_KEYの値をコピペすればOK。
5. MariaDBを起動
MAMPのコンソールから起動させる
6. .envのDB_DATABASEの値をcripto_trendにする
7. npm installしておく（Laravel Mix使うときにエラーになったら）
8. "npm run watch"でsassファイルの変更を監視して変更されたらcssに変換できる
