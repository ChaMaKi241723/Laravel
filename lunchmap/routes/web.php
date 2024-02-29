<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

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


//ルーティング
Route::get('/shops', [ShopController::class, 'index'])->name('shop.list');                                  //店舗一覧画面

Route::get('/shop/new', [ShopController::class, 'create'])->name('shop.new');                               //店舗新規作成画面
Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');                                 //新規作成確定処理

Route::get('/shop/edit/{id}', [ShopController::class, 'edit'])->name('shop.edit');                          //店舗情報編集画面
Route::post('/shop/update/{id}', [ShopController::class, 'update'])->name('shop.update');                   //情報更新確定処理

Route::get('/shop/createReview/{id}', [ShopController::class, 'createReview'])->name('shop.createReview');  //口コミ作成画面
Route::post('/shop/review}', [ShopController::class, 'review'])->name('shop.review');                       //口コミ投稿処理

Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.detail');                             //店舗情報画面

Route::delete('/shop/{id}', [ShopController::class, 'destroy'])->name('shop.destroy');                      //削除画面

//デフォルトでは店舗一覧画面へリダイレクト
Route::get('/', function () {
    return redirect('/shops');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//kenta-fujimaki-k21c@stu.kbc.ac.jp kenta130612 kenta
//kenta.laravel.test@gmail.com rokumaru130612 ろくまる社長