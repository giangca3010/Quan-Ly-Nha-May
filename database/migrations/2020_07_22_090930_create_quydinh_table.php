<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuydinhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quydinh', function (Blueprint $table) {
            $table->bigIncrements('quyDinh_id');
            $table->string('quyDinh_name');
            $table->string('quyTrinh_id');
            $table->text('noiDung');
            $table->string('cheTai_1');
            $table->string('cheTai_2');
            $table->string('cheTai_3');
            $table->string('cheTai_4');
            $table->string('cheTai_5');
            $table->string('roles_id_1');
            $table->string('roles_id_2');
            $table->string('maGiamSat');
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
        Schema::dropIfExists('quydinh');
    }
}
