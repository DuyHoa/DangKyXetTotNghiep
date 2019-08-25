<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDanhSachdukiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('danh_sachdukiens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('MaSV');
            $table->string('TenSV');
            $table->string('MaNganh');
            $table->string('Lop');
            $table->integer('MaDot');
            $table->integer('TinhTrang')->default('0');
            $table->integer('isDat')->default('0');
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
        Schema::dropIfExists('danh_sachdukiens');
    }
}
