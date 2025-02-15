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
        Schema::create('peminjaman_alats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_peminjaman_alat_bahan');
            $table->foreign('id_peminjaman_alat_bahan')->references('id')->on('peminjaman_alat_dan_bahans');
            $table->unsignedInteger('id_alat');
            $table->foreign('id_alat')->references('id')->on('alats');
            $table->integer('jumlah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_alats');
    }
};
