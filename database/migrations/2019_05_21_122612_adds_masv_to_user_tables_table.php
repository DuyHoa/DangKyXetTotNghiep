<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsMasvToUserTablesTable extends Migration
{
    public function up()
    {
        if(!(Schema::hasColumn('users', 'MaSV'))){
            Schema::table('users', function (Blueprint $table) {
                $table->string('MaSV', 50)->unique()->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('MaSV');
        });
    }
}
