<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    public function getMyMemo() {
        //クエリパラメータからタグidを取ってくる
        $query_tag = \Request::query('tag');

        //条件に応じたクエリを作成するために、共通部分をquery変数として定義
        $query = Memo::query()->select('memos.*')
                        ->where('user_id', '=', \Auth::id())
                        ->whereNull('deleted_at')
                        ->orderBy('updated_at', 'DESC');

        if(!empty($query_tag)) {
            //タグを指定していればそれに紐づくメモデータを取得ためにquery変数に条件を追加
            $query->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
                  ->where('memo_tags.tag_id', '=', $query_tag);
        }

        //query変数を実行して取得したメモをmemos変数に代入
        $memos = $query->get();

        //取得したメモを返す
        return $memos;
    }
}
