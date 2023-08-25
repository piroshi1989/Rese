#アプリケーション名
Rese
飲食店の来店予約のwebアプリケーション  
店舗検索や予約のCRUD処理ができる  
お気に入り機能、決済機能搭載  
  
![image](https://github.com/piroshi1989/Rese/assets/123999429/03f062c3-708e-4709-a909-167f9392ab13)
  

##作成した目的  
COACHTECH Web開発上級案件  

##アプリケーションURL  
  

##他のリポジトリ  
特になし  
  
##機能一覧  
・会員登録  
・ログイン  
・ログアウト  
・ユーザー情報取得  
・ユーザー飲食店予約情報取得  
・飲食店一覧取得  
・飲食店詳細取得  
・飲食店お気に入り追加、削除  
・飲食店予約情報追加、削除、更新  
・飲食店のエリア、ジャンル、店名で検索する検索機能  
・評価機能(予約時間が過ぎるとユーザーが店舗を5段階評価とコメントができる)  
バリデーション(ログイン、予約、評価、メール送信、店舗情報作成の際にバリデーションをかける)  
・権限管理(管理者、店舗代表者、利用者作成)  
・飲食店情報作成、更新(上記の店舗代表者のみ権限付与)  
・店舗代表者登録(上記の管理者のみ権限付与)  
・メール認証  
・メール送信機能(店舗代表者から利用者にお知らせメール送信)  
・リマインダー(当日予約の8:00に予約情報のメール送信)  
・QRコード作成(店舗代表者のみ照合可能。照合すると当日の予約情報確認画面へ遷移)  
・決済(Stripeを利用した決済)  
・レスポンシブデザイン(ブレイクポイント768px)  
  
##使用技術  
Laravel 8.75  
PHP 7.4.33  
mysql 8.0.33  
nginx 1.12.2  
  

##テーブル設計  
![image](https://github.com/piroshi1989/Rese/assets/123999429/465eb063-af8d-4b0b-8d6a-330aaab08ad8)  
![image](https://github.com/piroshi1989/Rese/assets/123999429/99488111-9b7c-48fe-867b-b180af4be424)  
![image](https://github.com/piroshi1989/Rese/assets/123999429/f5898d36-3c51-4d10-b5dc-a46a3e609084)  

##ER図  
![image](https://github.com/piroshi1989/Rese/assets/123999429/3f9f54f9-c773-403b-9c35-5f93afd95268)
  
##環境構築  
dockerでの環境構築  
//コマンドライン上で以下のコマンドを入力  
$ cd Rese  
$ docker-compose up -d --build  
$ docker-compose exec php bash  
//PHPコンテナ上で以下のコマンドを入力  
$ composer install  
$ composer require simplesoftwareio/simple-qr-code  
$ composer require stripe/stripe-php  
$ cp .env.example .env  
$ exit  

envファイルの以下の項目を修正  
DB_HOST=mysql  
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass  
STRIPE_PUBLIC_KEY=pk_test_51xxxxxxxxxxxxxxxxxxx  
STRIPE_SECRET_KEY=sk_test_51xxxxxxxxxxxxxxxxxxx  
*51以下は任意のkeyを入力  
  
$ php artisan key:generate  
$ php artisan migrate  
$ php artisan db:seed  
  
ホストOSのCronジョブを設定  
* * * * * cd /path/to/laravel && php artisan schedule:run >> /dev/null 2>&1  
*localではphpコンテナ内でphp artisan schedule:runを入力  
  
EC2での環境構築  
$ sudo yum install -y docker  
$ sudo service docker start  
$ sudo usermod -a -G docker ec2-user  
$ sudo mkdir -p /usr/local/lib/docker/cli-plugins  
$ sudo curl -SL https://github.com/docker/compose/releases/download/v2.4.1/docker-compose-linux-x86_64 -o /usr/local/lib/docker/cli-plugins/docker-compose  
$ sudo chmod +x /usr/local/lib/docker/cli-plugins/docker-compose  
$ sudo systemctl status docker
$ docker compose up -d  
$ docker compose exec php bash  
//PHPコンテナ上で以下のコマンドを入力  
$ composer install  
$ composer require endroid/qr-code  
$ composer require stripe/stripe-php  
$ cp .env.example .env  
$ exit  
以下はRDS,S3の接続を行う  


##他に記載することがあれば記述する
・アカウントの種類
テストユーザー mail:a@gmail.com password:password
店舗代表者    mail:b@gmail.com password:password
管理者       mail:c@gmail.com  password:password

・店舗の画像はS3に保存し、作成したバケットのURLをpathにしました
  
・追加実装項目の環境の切り分けではテスト環境用のEC2インスタンスを作成しました
RDSは別のインスタンスを接続しました  
テスト:http://ec2-52-194-30-90.ap-northeast-1.compute.amazonaws.com/login
テスト:
・

・EC2のlaravelでは.envのmail関連は設定していません。ですので、新規ユーザー作成の場合、認証はURLの末尾に:8080を追加してphpmyadminで直接入力をお願いします。  