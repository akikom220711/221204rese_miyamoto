# Rese
- 飲食店予約サービス
![Top image](/public/img_readme/rese_top_page.png)<br><br>

## 作成した目的
- 機能や画面がシンプルでより使い勝手の良い予約サービスを自社で持ちたいという依頼があったため。<br><br>

## アプリケーションURL
https://github.com/akikom220711/221204rese.git<br><br>

## 機能一覧
### 一般ユーザー用
- 会員登録機能（メール認証）<br>
ゲストでページを閲覧している際にメニューボタンから選択可能。<br>
また、ユーザー登録の際にメールアドレスの認証も行うことができる。<br>

- ユーザー認証機能（ログイン・ログアウト）<br>
ログイン：ゲストでページを閲覧している際にメニューボタンから選択可能<br>
ログアウト：ユーザー権限でページを閲覧している際にメニューボタンから選択可能<br>

- 飲食店一覧表示機能<br>
トップページに飲食店一覧が表示される<br>

- 飲食店詳細表示機能<br>
各飲食店の「詳細を見る」ボタンからアクセス可能<br>

- 飲食店予約機能（登録・削除・変更）<br>
ユーザーとしてログインしている状態で詳細ページから予約することができる。<br>
予約情報の変更と削除についてはマイページから行うことができる。<br>

- 予約リマインダー機能<br>
予約を行ったユーザーに対して当日の朝にリマインダーメールを送信することができる。<br>

- 飲食店お気に入り機能（登録・削除）<br>
ユーザーとしてログインしている状態で各飲食店毎に表示されるハートマークからお気に入り登録することができる。<br>
お気に入り店舗の一覧はマイページから確認することができる。<br>

- 飲食店検索機能（エリア・ジャンル・キーワード検索）<br>
トップページの検索フォームから店舗の検索を行うことができる。<br>

- 飲食店評価機能<br>
予約を削除する際に飲食店の評価を行うことができる。<br>
評価内容はevaluations tableに保存され、飲食店一覧等で評価値を確認することができる。<br>

- マイページ表示機能<br>
ユーザーとしてログインしている状態でメニューボタンから選択可能。<br>

- QRコードによる予約照合機能<br>
マイページの予約一覧に表示されるQRコードから予約情報を取得することが可能。<br>

- 決済機能<br>
マイページの予約一覧からstripeを介した決済を行うことができる。<br><br>

### 店舗代表者（manager）用
- 店舗代表者認証機能（ログイン・ログアウト）<br>
ログイン：店舗代表者用のログインページからログインする。店舗代表者用ログインページには通常ログインページ内のリンクからアクセスすることができる。<br>
ログアウト：店舗代表者でログインしているとき、メニューボタンから選択できる。<br>

- 新規店舗登録機能<br>
店舗代表者用ページの「店舗情報作成」ボタンから作成することができる。<br>

- 店舗情報更新機能<br>
店舗代表者用ページの「更新」ボタンから各店舗情報を変更することができる。<br>

- 予約情報一覧機能<br>
店舗代表者用ページの「予約一覧」ボタンから各店舗ごとの予約一覧を閲覧することができる。<br>

- メール送信機能<br>
店舗代表者用ページからユーザー宛にメールを送信することができる。<br><br>


### 管理者用（administrator）用
- 管理者認証機能（ログイン・ログアウト）<br>
ログイン：一般ユーザーと同じログインページからログインする。<br>
管理者用アカウントは<br>
メールアドレス：yyy@example.com、パスワード：yyyyyyyyy<br>
ログアウト：管理者としてログインしている状態でメニューボタンから選択可能。<br>

- 新規店舗代表者登録機能<br>
管理者用ページから店舗代表者を新たに登録することができる。<br>

- メール送信機能<br>
管理者用ページからユーザーもしくは店舗代表者宛にメールを送信することができる。<br><br>


## 使用技術（実行環境）
- Windows 10 home
- Laravel 8.X
- PHP 8.1.6
- XAMPP 
- Apache 2.4.53
- mySQL 15.1
- Google Chrome 107.0.5304.107
- FireFox 107.0
<br><br>

## テーブル設計
- Users table<br>
ユーザー登録用テーブル。管理者(permission=2)もこちらのテーブルに登録されている。<br>
![Users table image](/public/img_readme/users_table.png)

- Shops table<br>
店舗登録用テーブル。<br>
![Shops table image](/public/img_readme/shops_table.png)

- Favorites table<br>
お気に入り登録用テーブル。<br>
![Favorites table image](/public/img_readme/favorites_table.png)

- Reserves table<br>
予約情報登録用テーブル。<br>
![Reserves table image](/public/img_readme/reserves_table.png)

- Regions table<br>
地域登録テーブル。<br>
![Regions table image](/public/img_readme/regions_table.png)

- Categories table<br>
ジャンル登録テーブル。<br>
![Categories table image](/public/img_readme/categories_table.png)

- Managers table<br>
店舗代表者登録用テーブル。店舗代表者の認証に使われる。<br>
![Managers table image](/public/img_readme/managers_table.png)

- Evaluations table<br>
評価情報登録用テーブル。<br>
![Evaluations table image](/public/img_readme/evaluations_table.png)<br><br>

## ER図
- ER図
![ER image](/public/img_readme/221107_ER.png)<br><br>

# 環境構築
- テーブル設定<br>
テーブル設定はrese/databaseフォルダ内のマイグレーションファイルとシーダファイルを用いて行う。<br>

- メール送信設定<br>
本アプリケーションでメール送信を行う場合には、.envファイルのメール設定（MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION）を設定してから使用する。<br>

- stripeによる決済の設定<br>
.envファイルにstripeのAPIキーを記入する項目（STRIPE_KEY, STRIPE_SECRET）を追加した。
stripeによる決済機能を実行する場合にはこれらの項目にAPIキーを設定してから使用する。<br>

- テスト環境<br>
PHPUnitテスト環境用の設定ファイル.env.testingを作成した。<br><br>

## その他
### テスト用アカウント
#### 一般ユーザー
- name: 佐藤, email: aaa@example.com, password: aaaaaaaaa, 登録テーブル: users
- name: 鈴木, email: zzz@example.com, password: zzzzzzzzz, 登録テーブル: users

#### 店舗代表者
- name: 黒川, email: kkk@example.com, password: kkkkkkkkk, 登録テーブル: managers
- name: 足立, email: ppp@example.com, password: ppppppppp, 登録テーブル: managers

#### 管理者
- name: 山田, email: yyy@example.com, password: yyyyyyyyy, 登録テーブル: users




