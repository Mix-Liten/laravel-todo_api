<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// 註冊
Route::post('users', [UserController::class, 'store'])->name('signup');
// 登入
Route::post('tokens', [TokenController::class, 'store'])->name('login');

Route::middleware([
    'auth:sanctum',
])->group(function () {
    Route::apiResource('todos', TodoController::class)->except('show');

    // 登出
    Route::delete('tokens', [TokenController::class, 'destroy'])->name('logout');
});
