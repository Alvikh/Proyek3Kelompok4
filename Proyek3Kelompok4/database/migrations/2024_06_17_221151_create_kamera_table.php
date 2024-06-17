<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKameraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kamera', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gedung_id');
            $table->unsignedBigInteger('ruang_id');
            $table->string('nama_kamera');
            $table->string('sumber');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->foreign('gedung_id')->references('id')->on('gedung')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ruang_id')->references('id')->on('ruang')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kamera');
    }
}
