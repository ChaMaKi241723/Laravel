<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
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
        //スコア、生徒の一覧取得
        //取得処理はapp/Providers/AppServiceProvider.phpに記述
        return view('create');
    }



    //成績の新規追加
    //インスタンス化したリクエストを引数として利用
    public function store(Request $request)
    {
        $posts = $request->all();
        //バリデーション(必須項目の指定)
        $request->validate(['score' => 'required']);

        //dd...dimp die(メソッドの引数にとった値を展開して止める=データの確認をするデバッグ関数)
        //dd($posts);

        //DBに成績追加
        Score::insert(['student_id' => $posts['student_id'], 'subject_id' =>$posts['subject_id'], 'score' => $posts['score'], 'comment' => $posts['comment']]);

        //ホーム画面にリダイレクト
        return redirect( route('home') );
    }



    //成績の編集画面の取得
    public function edit($id) 
    {
        //編集用の成績の取得
        //その他viewに必要な情報の取得はapp/Providers/AppServiceProvider.phpに記述
        $edit_score = Score::select('scores.*')
                        ->where('scores.id', '=', $id)
                        ->get();

        return view('edit', compact('edit_score'));
    }



    //成績の編集
    public function update(Request $request) 
    {
        $posts = $request->all();
        $request->validate(['score' => 'required']);

        DB::transaction(function() use($posts) {
            //成績の更新
            Score::where('id', $posts['score_id'])
                    ->update(['student_id' => $posts['student_id'], 'subject_id' => $posts['subject_id'], 'score' => $posts['score'], 'comment' => $posts['comment']]);
        });

        //ホーム画面に飛ばす
        return redirect( route('home') );
    }



    //メモの削除(論理削除)
    public function destroy(Request $request) 
    {
        $posts = $request->all();

        //論理削除では行を削除するのではなく、「削除済みチェック」を行う
        score::where('id', $posts['score_id'])->update(['deleted_at' => date("Y-m-d H:i:s", time())]);

        return redirect( route('home') );
    }

}
