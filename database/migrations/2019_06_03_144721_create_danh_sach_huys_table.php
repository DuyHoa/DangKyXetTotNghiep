<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDanhSachHuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('danh_sach_huys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('MaSV');
            $table->string('TenSV');
            $table->integer('MaDot');
            $table->string('MaNganh');
            $table->integer('Diem')->default(0)->nullable();
            $table->integer('Tinchi')->default(0)->nullable();
            $table->integer('NN')->default(0)->nullable();
            $table->integer('Tudo')->default(0)->nullable();
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
        Schema::dropIfExists('danh_sach_huys');
    }
}
