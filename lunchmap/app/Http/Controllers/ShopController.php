<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {
        //except = 「除外」
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //shopモデルのデータをすべて取得
        $shops = Shop::all();

        //取得したデータをindexビューに渡す
        return view('index', ['shops'=>$shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //pluckメソッドで要素を取り出す
        $category = Category::all()->pluck('name', 'id');

        //店舗の新規登録画面に飛ばす
        return view('new', ['categories' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //新規登録して店舗詳細画面へリダイレクト
        $shop = new Shop;
        $user = \Auth::user();

        $shop->name = request('name');
        $shop->address = request('address');
        $shop->category_id = request('category_id');
        $shop->user_id = $user->id;
        $shop->save();
        return redirect()->route('shop.detail', ['id' => $shop->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //選択された店舗の情報を取得してビューに渡す
        $shop = Shop::find($id);
        $user = \Auth::user();
        $reviews = Review::all()->where('shop_id', '=', $id);//->pluck('text', 'user_id');
        //$category = Category::all()->pluck('name', 'id');

        if($user) {
            $login_user_id = $user->id;
        } else {
            $login_user_id = "";
        }

        if($reviews) {
            return view('show', ['shop' => $shop, 'login_user_id' => $login_user_id, 'reviews' => $reviews]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop, $id)
    {
        //編集対象の店舗情報を取得してビューに渡す
        $shop = Shop::find($id);
        $categories = Category::all()->pluck('name', 'id');
        return view('edit', ['shop' => $shop, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Shop $shop)
    {
        //編集して店舗詳細画面へリダイレクト
        $shop = Shop::find($id);
        $shop->name = request('name');
        $shop->address = request('address');
        $shop->category_id = request('category_id');
        $shop->save();
        return redirect()->route('shop.detail', ['id' => $shop->id]);
    }

    //口コミ作成画面への変遷
    public function createReview($id)
    {
        //店舗情報と編集者情報をビューに渡す
        $shop = Shop::find($id);
        return view('review', ['shop' => $shop]);
    }

    //口コミ投稿処理
    public function review(Request $request)
    {
        //新規登録して店舗詳細画面へリダイレクト
        $review = new Review;
        $user = \Auth::user()->pluck(id);

        $review->shop_id = request('id');
        $review->text = request('text');
        $review->user_id = $user;
        $review->save();
        return redirect()->route('shop.detail', ['id' => $shop->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //選択された店舗情報を削除して一覧画面へリダイレクト
        $shop = Shop::find($id);
        $shop->delete();
        return redirect('/shops');
    }
}
