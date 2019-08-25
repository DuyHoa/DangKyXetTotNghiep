<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChuongTrinhHocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chuong_trinh_hocs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('MaMon');
            $table->string('TenMon');
            $table->string('Tinchi');
            $table->string('Term');
            $table->string('Nganh');
            $table->string('khoa');
            $table->string('khoas');
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
        Schema::dropIfExists('chuong_trinh_hocs');
    }
}
