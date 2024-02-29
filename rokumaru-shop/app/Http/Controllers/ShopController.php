<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //shopモデルのデータをすべて取得
        $products = Product::all();
        //取得したデータをindexビューに渡す
        return view('index', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //指定されたidに合致する商品情報をshopモデルから取得
        $product = Product::find($id);
        //取得したデータをビューに渡す
        return view('show', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    //カートに追加
    public function cartin(Request $request) {
        //カートセッション内に同じ商品があればエラー
        if(session()->exists(request('code'))) {
            return redirect()->route('product.detail')->with('errorMessage', 'すでにカートに入っています');
        }

        //保存してトップページにリダイレクト
        $request->session()->put(['code' => request('code'), 'qty' => request('qty')]);
        return redirect()->route('product.list');
    }

    //カート表示
    public function cart(Request $request) {
        $datas = $request->session()->all();
        return view('cart', ['request' => $request]);
    }

    //カート内の商品数量の変更を保存
    public function cart_update(Request $request) {

    }

    //カートから商品を削除
    public function cart_delete(Request $request) {

    }

    //カートの中身を全削除
    public function cart_clear(Request $request) {
        session()->flush();
        
    }
}
