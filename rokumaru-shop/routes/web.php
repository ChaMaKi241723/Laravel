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

//商品一覧
Route::get('/products', [ShopController::class, 'index'])->name('product.list');
//商品詳細
Route::get('/product/{id}', [ShopController::class, 'show'])->name('product.detail');

//カートに追加
Route::post('/shop/cartin', [ShopController::class, 'cartin'])->name('shop.cartin');
//カートの中身を表示
Route::get('/shop/cart', [ShopController::class, 'cart'])->name('shop.cart');



Route::get('/', function () {
    return redirect('/products');
});



/*
<table class='table table-striped table-hover'>
        <tr>
            <th>商品名</th><th>数量</th>
        </tr>
        @foreach()
            <tr>
                <td>
                    {{  }}
                </td>
                <td>
                    {{  }}
                </td>
            </tr>
        @endforeach
    </table>
*/
