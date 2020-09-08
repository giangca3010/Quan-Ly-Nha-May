<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXinNghiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xinNghi', function (Blueprint $table) {
            $table->increments('xinNghi_id');
            $table->string('id_user1');
            $table->string('id_roles');
            $table->string('id_user2');
            $table->string('ngayNghi');
            $table->string('soDienThoai');
            $table->text('lyDo');
            $table->text('banGiao');
            $table->string('id_user3');
            $table->dateTime('ngayXinNghi', 0);;
            $table->dateTime('ketThucNgay', 0);
            $table->integer('trangThaiNghi');
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
        Schema::dropIfExists('xinNghi');
    }
}
