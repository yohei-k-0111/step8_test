<?php

use Illuminate\Support\Facades\Route;
// "Route"というツールを使うために必要な部品を取り込む。
use App\Http\Controllers\ProductController;
// ProductControllerに繋げるために取り込む。
use Illuminate\Support\Facades\Auth;
// "Auth"という部品を使うために取り込む。ユーザー認証（ログイン）に関する処理を行う。


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
    // ウェブサイトのホームページ（'/'のURL）にアクセスした場合のルート
    if (Auth::check()) {
        // ログイン状態ならば商品一覧ページ（ProductControllerのindexメソッドが処理）にリダイレクト
        return redirect()->route('products.index');
    } else {
        // ログイン状態でなければログイン画面へリダイレクト
        return redirect()->route('login');
    }
});

Auth::routes();

// Auth::routes();はLaravelが提供している便利な機能で
// 一般的な認証に関するルーティングを自動的に定義してくれます
// この一行を書くだけで、ログインやログアウト
// パスワードのリセット、新規ユーザー登録などのための
// ルートが作成されます。
//　つまりログイン画面に用意されたビューのリンク先がこの1行で済みます

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'products.index'])->name('home');

Route::get('/home', function () {
    // ウェブサイトのホームページ（'/'のURL）にアクセスした場合のルート
    if (Auth::check()) {
        // ログイン状態ならば商品一覧ページ（ProductControllerのindexメソッドが処理）へリダイレクト
        return redirect()->route('products.index');
    } else {
        // ログイン状態でなければログイン画面へリダイレクト
        return redirect()->route('login');
    }
});
