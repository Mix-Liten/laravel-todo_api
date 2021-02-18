# laravel-todo_api_sample

## Info

練習使用 [Laravel](https://laravel.com/) 框架開發後端 API，實作細項如下：

1. 環境設定
   - 資料庫
     - 使用 [Laradock](https://laradock.io/) 的 [MySQL 5.7](https://www.mysql.com/)
   - 站點
     - 使用 [Laradock](https://laradock.io/) 的 [Nginx](https://www.nginx.com/) / [Caddy](https://caddyserver.com/)
2. 建立資料表，欄位如下
    ```PHP
    Schema::create('todos', function (Blueprint $table) {
        $table->id();
        $table->string('content');
        $table->boolean('is_completed')->default(false);
        $table->integer('created_by')->nullable();
        $table->timestamps();
    });
    ```
3. 建立假資料
   - 建立關聯，欄位中的 `created_by` 會記錄是哪個使用者建立該筆資料，因此要在 `User` 及 `Todo` 等 `Model` 中建立一對多關係
   - 待續...