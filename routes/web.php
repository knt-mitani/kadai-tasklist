<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 初期画面で使用(ログイン or 未ログイン判定処理)
Route::get('/', [TasksController::class, 'index']);

require __DIR__.'/auth.php';

// ログイン後のみ機能する(authミドルウェア使用のため)
Route::group(['middleware' => ['auth']], function() {
    Route::resource('tasks', TasksController::class);
});