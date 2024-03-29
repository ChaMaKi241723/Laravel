<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table -> unsignedBigInteger('id', true);
            $table -> String('name');
            $table -> unsignedBigInteger('user_id');
            //論理削除を定義→deleted_atを自動生成
            $table -> softDeletes();
            //timestampと書いてしまうと、レコード挿入時と更新時に値が入らないので、DB::rawで直接書く
            $table -> timestamp('update_at') -> default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table -> timestamp('created_at') -> default(\DB::raw('CURRENT_TIMESTAMP'));
            $table -> foreign('user_id') -> references('id') -> on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
