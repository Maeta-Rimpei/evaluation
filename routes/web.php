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
    // 職員一覧
    Route::get('admin/index', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('adminIndex');
    Route::get('admin/show_staff', [App\Http\Controllers\Admin\AdminController::class, 'showStaff'])->name('showStaff');
    Route::get('admin/staff_detail/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showStaffDetail'])->name('showStaffDetail');
    Route::get('admin/search_staff', [App\Http\Controllers\Admin\AdminController::class, 'searchStaff'])->name('searchStaff');
    // 職員登録
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register_exe', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('create');
    // 職員削除
    Route::get('show_deleted', [App\Http\Controllers\Admin\AdminController::class, 'showStaffSoftDeleted'])->name('showStaffSoftDeleted');
    Route::get('exe_deleted/{id}', [App\Http\Controllers\Admin\AdminController::class, 'exeStaffSoftDeleted'])->name('exeStaffSoftDeleted');
    // 自己評価シート編集
    Route::get('show_edit', [App\Http\Controllers\Admin\AdminController::class, 'showQuestionEdit'])->name('showQuestionEdit');
    Route::get('show_detail_edit/{role_id}', [App\Http\Controllers\Admin\AdminController::class, 'showDetailQuestionEdit'])->name('showDetailQuestionEdit');
    Route::get('edit_form/{question_id}', [App\Http\Controllers\Admin\AdminController::class, 'editForm'])->name('editForm');
    Route::patch('edit_exe/{question_id}', [App\Http\Controllers\Admin\AdminController::class, 'editExe'])->name('editExe');
    Route::get('exe_question_deleted/{question_id}', [App\Http\Controllers\Admin\AdminController::class, 'exeQuestionSoftDeleted'])->name('exeQuestionSoftDeleted');
    Route::get('show_create_question', [App\Http\Controllers\Admin\AdminController::class, 'showCreateQuestion'])->name('showCreateQuestion');
    Route::post('exe_create_question', [App\Http\Controllers\Admin\AdminController::class, 'exeCreateQuestion'])->name('exeCreateQuestion');
    Route::get('show_search_question', [App\Http\Controllers\Admin\AdminController::class, 'searchQuestion'])->name('searchQuestion');
    
    
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
