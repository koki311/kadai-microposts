<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('micropost_id');
            $table->timestamps();
            
            //外部キー制約
            //$table->foreign(外部キー制約を設定するカラム名)->references(参照されるカラム名)->on(参照されるテーブル名);
            //user_idはusersテーブルのidのみ
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //micropost_idはmicropostsテーブルのidのみ
            $table->foreign('micropost_id')->references('id')->on('microposts')->onDelete('cascade');
            
            
            //user_idとmicroposts_idは重複して保存しない
            $table->unique(['user_id','micropost_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
