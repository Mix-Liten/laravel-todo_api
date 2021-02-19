# laravel-todo_api_sample

## Environment

- PHP v7.4.0
- laravel/framework v8.9.0
- laravel/sanctum v2.6.0
- Node.js 12.20.0

## Info

練習使用 [Laravel](https://laravel.com/) 框架開發後端 API，實作細項如下：

1. 環境設定
   - 資料庫
     - 使用 [Laradock](https://laradock.io/) 的 [MySQL 5.7](https://www.mysql.com/)
   - 站點
     - 使用 [Laradock](https://laradock.io/) 的 [Nginx](https://www.nginx.com/) / [Caddy](https://caddyserver.com/)
2. 設定資料表，欄位如下
    ```PHP
    Schema::create('todos', function (Blueprint $table) {
        $table->id();
        $table->string('content');
        $table->boolean('is_completed')->default(false);
        $table->integer('created_by')->nullable();
        $table->timestamps();
    });
    ```
3. 設定關聯＆假資料格式＆設定假資料種子＆建立資料表
   - 建立關聯，欄位中的 `created_by` 會記錄是哪個使用者建立該筆資料，因此要在 `User` 及 `Todo` 等 `Model` 中建立一對多關聯
   - 定義假資料格式及內容，使用已被整合的 [FakerPHP/Faker](https://github.com/FakerPHP/Faker) 套件設定假資料內容，之後在 `DatabaseSeeder` 設定假資料的建立方式
   - 執行 `php artisan migrate:fresh --seed` 建立資料表
4. 建立 Controller 及相關設計模式
   - Service Layer，集中處理商業邏輯，其中存取/修改資料的方法可再拆出 Repository Pattern，因範例相對單純，大多只對到單一資料表，故省略後者
   - Request Validation，驗證請求附帶資料的格式
   - API Resource，設定資料回傳格式
   - Authorization Policy，驗證身份是否有操作權限
5. 設定 routes
   - 部分路由使用官方的 [Sanctum](https://github.com/laravel/sanctum) Middleware 驗證身份，這次是使用給前後端分離專案使用的驗證方式
   - 將 Controller 的方法分派給各個路由
6. 寫測試
   - 驗證 API 可能會發生的狀況，確認正常取得資料及請求參數錯誤...等行為皆符合預期

## Development

- 啟用/停用環境
   ```bash
   # 第一次啟用
   $ docker-compose up -d nginx mysql
   # 之後啟用
   $ docker-compose up -d
   # 停用
   $ docker-compose stop
   ```
- 進資料庫虛擬機內查看資料
   ```bash
   $ docker-compose exec mysql bash
   $ mysql -u <user> -p
   ```
- 一些 Laravel 相關指令
   ```bash
   # 清除所有快取
   $ php artisan optimize
   # 列出路由清單
   $ php artisan route:list
   # 清空資料庫
   $ php artisan migrate:reset
   # 重置資料庫，同時使用種子建立假資料
   $ php artisan migrate:fresh --seed
   ```
- 執行測試
   ```
   $ php artisan test
   ```

## Conclusion

離上次使用 Laravel 有一段時間了，直接從 v5.8 跳到 v8.9，多少有些地方稍微會卡到，這次用這套來實作一個相對完整的 API，用在公司討論會和前端同事分享，正常的 API 開發時應該有的各種細節。

老實說光上面這些部分就花了我五天左右時間，原先預計還會有個 [Swagger](https://petstore.swagger.io/) 文件，但時間不夠改用 [Postman - API Documentation](https://www.postman.com/api-documentation-tool/) 做示範，之後有時間再加上去。

Notice：這個專案只是一個範例，實際後端會處理的資料庫、商業邏輯、併發、快取、...等等，領域更深、更複雜。

PS：其實順帶想要酸某些後端，不允許跨網域的狀況就不提了，欄位長度不講、以為 API 只有一種使用方式就不處理 Exception、資料格式不固定、濫用 HTTP Status Code...，總之各種狀況，前端多了解一點這部分，在釐清問題部分有幫助，雖然這可能不在職責內，多學一點總是好的。