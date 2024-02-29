<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\Tag;
use App\Models\MemoTag;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //タグ取得
        $tags = Tag::where('user_id', '=', \Auth::id())
                    ->whereNull('deleted_at')
                    ->orderBy('id', 'DESC')
                    ->get();

        return view('create', compact('tags'));
    }



    //メモの新規追加
    //インスタンス化したリクエストを引数として利用
    public function store(Request $request)
    {
        $posts = $request->all();
        //バリデーション(必須項目の指定)
        $request->validate(['content' => 'required']);

        //dd...dimp die(メソッドの引数にとった値を展開して止める=データの確認をするデバッグ関数)
        //dd($posts);
        //dd(\Auth::id());

        //トランザクション(メモとタグの新規追加)
        DB::transaction(function() use($posts) {
            //insertGetIdはテーブルにデータを挿入すると同時にそのデータを返してくれる
            $memo_id = Memo::insertGetId(['content' => $posts['content'], 'user_id' => \Auth::id()]);
            $tag_exists = Tag::where('user_id', '=', \Auth::id())->where('name', '=', $posts['new_tag'])
            ->exists();
            if((!empty($posts['new_tag']) || $posts['new_tag'] === "0") && !$tag_exists) {
                //dd('新規タグ');
                //Tagテーブルにデータを挿入しながら新規タグのタグIDを取得
                $tag_id = Tag::insertGetId(['user_id' => \Auth::id(), 'name' => $posts['new_tag']]);
                //insertGetIdで取得したメモIDとタグIDをMemoTagテーブルに挿入して紐づけ
                MemoTag::insert(['memo_id' => $memo_id, 'tag_id' => $tag_id]);
            }

            //既存タグが紐づけられた場合
            if(!empty($posts['tags'][0])) {
                foreach($posts['tags'] as $tag) {
                    MemoTag::insert(['memo_id' => $memo_id, 'tag_id' => $tag]);
                }
            }
        });

        //ホーム画面にリダイレクト
        return redirect( route('home') );
    }



    //メモとタグの編集画面の取得
    public function edit($id) 
    {
        //編集用のメモも取得
        $edit_memo = Memo::select('memos.*', 'tags.id AS tag_id')
                        ->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
                        ->leftJoin('tags', 'memo_tags.tag_id', '=', 'tags.id')
                        ->where('memos.user_id', '=', \Auth::id())
                        ->where('memos.id', '=', $id)
                        ->whereNull('memos.deleted_at')
                        ->get();
        
        //編集用のメモが持つタグIDを格納する配列
        $include_tags = [];
        foreach($edit_memo as $memo) {
            array_push($include_tags, $memo['tag_id']);
        }

        //タグ取得
        $tags = Tag::where('user_id', '=', \Auth::id())
                    ->whereNull('deleted_at')
                    ->orderBy('id', 'DESC')
                    ->get();

        return view('edit', compact('edit_memo', 'include_tags', 'tags'));
    }



    //メモとタグの編集
    public function update(Request $request) 
    {
        $posts = $request->all();
        $request->validate(['content' => 'required']);

        DB::transaction(function() use($posts) {
            //更新するメモを取ってくる
            Memo::where('id', $posts['memo_id'])->update(['content' => $posts['content']]);

            //メモとタグの紐づけを一旦削除
            MemoTag::where('memo_id', '=', $posts['memo_id'])->delete();

            //タグが指定されていれば、指定されたタグとメモを紐づけ
            if(!empty($posts['tags'])) {
                foreach($posts['tags'] as $tag) {
                    MemoTag::insert(['memo_id' => $posts['memo_id'], 'tag_id' =>$tag]);
                }
            }

            //タグの新規追加があれば以下の処理
            $tag_exists = Tag::where('user_id', '=', \Auth::id())->where('name', '=', $posts['new_tag'])
            ->exists();

            if((!empty($posts['new_tag']) || $posts['new_tag'] === "0") && !$tag_exists) {
                //Tagテーブルにデータを挿入しながら新規タグのタグIDを取得
                $tag_id = Tag::insertGetId(['user_id' => \Auth::id(), 'name' => $posts['new_tag']]);
                //insertGetIdで取得したメモIDとタグIDをMemoTagテーブルに挿入して紐づけ
                MemoTag::insert(['memo_id' => $posts['memo_id'], 'tag_id' => $tag_id]);
            }
        });

        //ホーム画面に飛ばす
        return redirect( route('home') );
    }



    //メモの削除(論理削除)
    public function destroy(Request $request) 
    {
        $posts = $request->all();

        //論理削除では行を削除するのではなく、「削除済みチェック」を行う
        Memo::where('id', $posts['memo_id'])->update(['deleted_at' => date("Y-m-d H:i:s", time())]);

        return redirect( route('home') );
    }

}
