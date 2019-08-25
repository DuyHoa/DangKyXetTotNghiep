<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBangDieuKiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bang_dieu_kiens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('MaNganh');
            $table->integer('MaDot');
            $table->string('TongTC');
            $table->string('DiemTB');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bang_dieu_kiens');
    }
}
