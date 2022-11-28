<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

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

Route::get('/', function () {
    return view('first');
  });

// ログイン前の処理
Route::group(['middleware' => ['guest:admin']], function () {
    // ログイン画面
    Route::get('admin/login', [App\Http\Controllers\Admin\AdminController::class, 'showLogin'])->name('adminShowLogin');

    // ログインフォームの送信
    Route::post('admin/login/post', [App\Http\Controllers\Admin\AdminController::class, 'login'])->name('adminLogin');
});

// ログイン後の処理
Route::group(['middleware' => ['auth:admin']], function () {

    // -----------------------------------管理画面-----------------------------------
    Route::get('admin/index', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('adminIndex');
    Route::get('admin/show_staff', [App\Http\Controllers\Admin\AdminController::class, 'showStaff'])->name('showStaff');
    Route::get('admin/staff_detail/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showStaffDetail'])->name('showStaffDetail');

    // ログアウト処理
    Route::get('admin/logout', [App\Http\Controllers\Admin\AdminController::class, 'logout'])->name('adminLogout');
});

// -----------------------------------管理者以外のユーザー-----------------------------------
Auth::routes();

// 回答フォーム
Route::get('/home', [App\Http\Controllers\EvaluationController::class, 'index'])->name('home');
Route::get('/evaluation_form', [App\Http\Controllers\EvaluationController::class, 'evaluationForm'])->name('evaluationForm');
Route::post('/evaluation_store', [App\Http\Controllers\EvaluationController::class, 'evaluationStore'])->name('evaluationStore');
Route::get('/completed,', [App\Http\Controllers\EvaluationController::class, 'evaluationCompleted'])->name('evaluationCompleted');
