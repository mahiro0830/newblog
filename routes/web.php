<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\EntriesController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TaxonomyController;
use App\Http\Controllers\Admin\ConfigController;

// TOPページ（記事一覧ページ）
Route::get('/', [EntriesController::class, 'index'])->name('index');
// 記事詳細ページ
Route::get('post/{id}/', [EntriesController::class, 'detail']);
// カテゴリー別記事一覧
Route::get('category/{category}/', [EntriesController::class, 'category'])->name('category');
// タグ別記事一覧
Route::get('tag/{tag}/', [EntriesController::class, 'tag'])->name('tag');
// ログイン前の処理
Route::group(['middleware' => ['guest:admin']], function () {
    // ログイン画面
    Route::get('admin/login_form', [AuthController::class, 'showLogin'])->name('admin.showLogin');
    // ログインフォームの送信
    Route::post('admin/login_form', [AuthController::class, 'login'])->name('admin.login');
});
// ログイン後の処理
Route::group(['middleware' => ['auth:admin']], function () {
    // 管理画面
    Route::get('admin', [AuthController::class, 'index'])->name('admin.index');
        // 記事TOP（TOP）
        Route::get('admin/post', [PostController::class, 'index'])->name('admin.post.index');
            // 記事の新規投稿画面
            Route::get('admin/post/add', [PostController::class, 'add'])->name('admin.post.add');
            // 記事の投稿
            Route::post('admin/post/add', [PostController::class, 'addPost']);
            // 記事の編集画面
            Route::get('admin/post/edit', [PostController::class, 'edit'])->name('admin.post.edit');
            // 記事の更新
            Route::post('admin/post/edit', [PostController::class, 'editPost']);
            // 記事の削除
            Route::get('admin/post/delete_one', [PostController::class, 'deleteOne'])->name('admin.post.delete');
            // 記事の複製
            Route::get('admin/post/replicate_one', [PostController::class, 'replicateOne'])->name('admin.post.replicate');
        // カテゴリ一覧
        Route::get('admin/categories', [TaxonomyController::class, 'index'])->name('admin.categories');
            // カテゴリー登録
            route::post('admin/categories/register', [TaxonomyController::class, 'register'])->name('admin.categories.register');
            // カテゴリー削除
            Route::get('admin/categories/delete', [TaxonomyController::class, 'delete'])->name('admin.categories.delete');
            // カテゴリー更新
            Route::post('admin/categories/update', [TaxonomyController::class, 'update'])->name('admin.categories.update');
        // タグ一覧
        Route::get('admin/tags', [TaxonomyController::class, 'index'])->name('admin.tags');
            // タグ登録
            route::post('admin/tags/register', [TaxonomyController::class, 'register'])->name('admin.tags.register');
            // タグ削除
            route::get('admin/tags/delete', [TaxonomyController::class, 'delete'])->name('admin.tags.delete');
            // タグ削除
            route::post('admin/tags/update', [TaxonomyController::class, 'update'])->name('admin.tags.update');
        // 設定画面
        Route::get('admin/config', [ConfigController::class, 'index'])->name('admin.config');
        // 設定画面（設定保存）
        Route::post('admin/config', [ConfigController::class, 'save'])->name('admin.config.save');
    // ログアウト処理
    Route::get('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
});
