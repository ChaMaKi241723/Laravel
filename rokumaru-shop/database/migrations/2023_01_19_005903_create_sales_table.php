<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->integer('member_id');
            $table->string('name', 30);
            $table->string('email', 100);
            $table->string('post_01', 3);
            $table->string('post_02', 4);
            $table->string('address', 100);
            $table->string('tel', 13);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
