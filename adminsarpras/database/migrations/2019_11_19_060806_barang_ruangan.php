<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BarangRuangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roomItem', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('item_id');
            $table->integer('room_id');
            $table->integer('total');
            $table->string('tanggal_barang_masuk');
            $table->string('merk');
            $table->integer('total_rusak')->nullable();
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
        //
    }
}
