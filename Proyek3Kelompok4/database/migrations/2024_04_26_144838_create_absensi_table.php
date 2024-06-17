<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('gedung_id');
            $table->unsignedBigInteger('ruang_id');
            $table->unsignedBigInteger('kamera_id');
            $table->timestamp('waktu_masuk')->nullable();
            $table->timestamp('waktu_keluar')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('gedung_id')->references('id')->on('gedung')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ruang_id')->references('id')->on('ruang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kamera_id')->references('id')->on('kamera')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
