<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    public function getMyScore() {
        //クエリパラメータから生徒idを取ってくる
        $query_student = \Request::query('student');

        //条件に応じたクエリを作成するために、共通部分をquery変数として定義
        $query = Score::query()->select('scores.*')
                        ->whereNull('scores.deleted_at')
                        ->orderBy('scores.updated_at', 'ASC');

        if(!empty($query_student)) {
            //生徒を指定していればそれに紐づく成績データを取得ためにquery変数に条件を追加
            $query->leftJoin('students', 'students.id', '=', 'scores.student_id')
                  ->where('students.id', '=', $query_student);
        }

        //query変数を実行して取得したメモをmemos変数に代入
        $scores = $query->get();

        //取得したメモを返す
        return $scores;
    }
}
