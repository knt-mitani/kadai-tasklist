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

// トップページ(ログイン前)
// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/', [TasksController::class, 'index']);

// ユーザー投稿画面
//Route::get('/tasklist', [TasksController::class, 'index'])->middleware(['auth'])->name('tasklist');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

//Route::put('/tasks/{id}', [TasksController::class, 'update'])->name('tasks.update');
// Route::delete('tasks/{id}', [TasksController::class, 'destroy'])->name('tasks.destroy');

require __DIR__.'/auth.php';

//Route::resource('tasks', TasksController::class);
// ログイン後のみ機能する(authミドルウェア使用のため)
Route::group(['middleware' => ['auth']], function() {
    Route::resource('tasks', TasksController::class);
});