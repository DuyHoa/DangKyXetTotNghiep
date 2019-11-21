<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDanhSachChinhThucsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('danh_sach_chinh_thucs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('MaSV');
            $table->string('TenSV');
            $table->string('MaNganh');
            $table->string('Lop');
            $table->integer('MaDot');
            $table->string('Rank');
            $table->integer('TrangThai');
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
        Schema::dropIfExists('danh_sach_chinh_thucs');
    }
}
