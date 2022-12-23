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
    Route::get('/admin/login', [App\Http\Controllers\Admin\AdminController::class, 'showLogin'])->name('adminShowLogin');

    // ログインフォームの送信
    Route::post('/admin/login/post', [App\Http\Controllers\Admin\AdminController::class, 'login'])->name('adminLogin');
});

// ログイン後の処理
Route::group(['middleware' => ['auth:admin']], function () {

    // -----------------------------------管理画面-----------------------------------
    // インデックス
    Route::get('/admin/index', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('adminIndex');

    // 職員一覧
    Route::get('/admin/show_staff', [App\Http\Controllers\Admin\AdminController::class, 'showStaff'])->name('showStaff');
    Route::get('/admin/staff_detail/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showStaffDetail'])->name('showStaffDetail');
    Route::get('/admin/search_staff', [App\Http\Controllers\Admin\AdminController::class, 'searchStaff'])->name('searchStaff');

    // 職員登録
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/exe_register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('create');
    // 職員評価
    Route::get('/evaluation_staff/{id}', [App\Http\Controllers\Admin\AdminController::class, 'evaluationStaff'])->name('evaluationStaff');
    Route::patch('/exe_evaluation_staff/{id}', [App\Http\Controllers\Admin\AdminController::class, 'exeEvaluationStaff'])->name('exeEvaluationStaff');
    // 編集
    Route::patch('/exe_edit_evaluation_staff/{id}', [App\Http\Controllers\Admin\AdminController::class, 'exeEditEvaluationStaff'])->name('exeEditEvaluationStaff');

    // 職員削除
    Route::get('/show_deleted', [App\Http\Controllers\Admin\AdminController::class, 'showStaffSoftDeleted'])->name('showStaffSoftDeleted');
    Route::get('/exe_deleted/{id}', [App\Http\Controllers\Admin\AdminController::class, 'exeStaffSoftDeleted'])->name('exeStaffSoftDeleted');

    // 管理者一覧
    Route::get('/show_admin', [App\Http\Controllers\Admin\AdminController::class, 'showAdmin'])->name('showAdmin');
    Route::get('/search_admin', [App\Http\Controllers\Admin\AdminController::class, 'searchAdmin'])->name('searchAdmin');

    // 管理者登録
    Route::get('/admin_register', [App\Http\Controllers\Auth\RegisterController::class, 'showAdminRegistrationForm'])->name('adminRegister');
    Route::post('/exe_register_admin', [App\Http\Controllers\Auth\RegisterController::class, 'exeAdminRegistrationForm'])->name('exeAdminRegister');
    // 管理者削除
    Route::get('/show_deleted_admin', [App\Http\Controllers\Admin\AdminController::class, 'showAdminSoftDeleted'])->name('showAdminSoftDeleted');
    Route::get('/exe_deleted_admin/{id}', [App\Http\Controllers\Admin\AdminController::class, 'exeAdminSoftDeleted'])->name('exeAdminSoftDeleted');

    // 自己評価シート編集
    Route::get('show_edit', [App\Http\Controllers\Admin\AdminController::class, 'showQuestionEdit'])->name('showQuestionEdit');
    Route::get('show_detail_edit/{role_id}', [App\Http\Controllers\Admin\AdminController::class, 'showDetailQuestionEdit'])->name('showDetailQuestionEdit');
    Route::get('edit_form/{question_id}', [App\Http\Controllers\Admin\AdminController::class, 'editForm'])->name('editForm');
    Route::patch('edit_exe/{question_id}', [App\Http\Controllers\Admin\AdminController::class, 'editExe'])->name('editExe');
    Route::get('exe_question_destroyed/{question_id}', [App\Http\Controllers\Admin\AdminController::class, 'exeQuestionDestroyed'])->name('exeQuestionDestroyed');
    Route::get('show_create_question', [App\Http\Controllers\Admin\AdminController::class, 'showCreateQuestion'])->name('showCreateQuestion');
    Route::post('exe_create_question', [App\Http\Controllers\Admin\AdminController::class, 'exeCreateQuestion'])->name('exeCreateQuestion');
    Route::get('show_search_question', [App\Http\Controllers\Admin\AdminController::class, 'searchQuestion'])->name('searchQuestion');

    // 回答編集
    Route::get('/show_edit_answer', [App\Http\Controllers\Admin\AdminController::class, 'showEditAnswer'])->name('showEditAnswer');
    Route::get('/exe_all_deleted_answer/{id}', [App\Http\Controllers\Admin\AdminController::class, 'exeAllDeletedAnswer'])->name('exeAllDeletedAnswer');
    Route::get('/show_part_edit_answer/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showPartEditAnswer'])->name('showPartEditAnswer');
    Route::get('/exe_part_deleted_answer/{answer_id}', [App\Http\Controllers\Admin\AdminController::class, 'exePartDeletedAnswer'])->name('exePartDeletedAnswer');
    Route::get('/show_updated_answer/{answer_id}', [App\Http\Controllers\Admin\AdminController::class, 'showUpdatedAnswer'])->name('showUpdatedAnswer');
    Route::patch('/exe_updated_answer/{answer_id}', [App\Http\Controllers\Admin\AdminController::class, 'exeUpdatedAnswer'])->name('exeUpdatedAnswer');

    // ログアウト処理
    Route::get('/admin/logout', [App\Http\Controllers\Admin\AdminController::class, 'logout'])->name('adminLogout');
});

// -----------------------------------管理者以外のユーザー-----------------------------------
Auth::routes();

// ホーム画面
Route::get('/home', [App\Http\Controllers\EvaluationController::class, 'index'])->name('home');
Route::get('/confirm_answers', [App\Http\Controllers\EvaluationController::class, 'confirmAnswers'])->name('confirmAnswers');
Route::get('/confirm_feedback', [App\Http\Controllers\EvaluationController::class, 'confirmFeedback'])->name('confirmFeedback');
Route::get('/show_change_password', [App\Http\Controllers\EvaluationController::class, 'showChangePassword'])->name('showChangePassword');
Route::post('/exe_change_password', [App\Http\Controllers\EvaluationController::class, 'exeChangePassword'])->name('exeChangePassword');

// 回答フォーム
Route::get('/evaluation_form', [App\Http\Controllers\EvaluationController::class, 'evaluationForm'])->name('evaluationForm');
Route::post('/evaluation_store', [App\Http\Controllers\EvaluationController::class, 'evaluationStore'])->name('evaluationStore');
Route::get('/completed,', [App\Http\Controllers\EvaluationController::class, 'evaluationCompleted'])->name('evaluationCompleted');
