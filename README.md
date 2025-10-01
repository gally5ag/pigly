PigLy アプリ

環境構築
1，git@github.com:gally5ag/pigly.git 
2，docker-compose up-d--build
3docker-compose exec php bash
4composer install 
5env.example ファイルから .env を作成し、環境変数を変更 
6composer require laravel/fortifyでユーザー認証可能に
7php artisan migrateでテーブル設計からマイグレーションを作成
8ページ作成
9php artisan vendor:publish --tag=laravel-paginationでページネーション作成
12php artisan make:factory WeightLogsFactoryでダミーデータ作成、３５件
11php artisan db:seedでデータ作成
12レイアウト調整

使用技術
PHP 8.3.6
Laravel 8.83.8 
laravel/fortify 1.19
MySQL 8.0
テストユーザー　john
メールアドレス：test1@email.com
パスワード：coachtech

URL
https://github.com/gally5ag/pigly.git
