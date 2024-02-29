<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Memo;
use App\Models\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //全てのメソッドが呼び出される前に呼び出される(ビューコンポーザー)
        view()->composer('*', function($view) {
            //Memoモデルをインスタンス化し、getMyMemo関数でメモを取得
            $memo_model = new Memo();
            $memos = $memo_model->getMyMemo();
            
            //タグも取得
            $tags = Tag::where('user_id', '=', \Auth::id())
                        ->whereNull('deleted_at')
                        ->orderBy('id', 'DESC')
                        ->get();

            //with(viewで使いたい名前、渡したい変数名)
            $view->with('memos', $memos)->with('tags', $tags);
        });
    }
}
