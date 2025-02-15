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
        Schema::create('peminjaman_alat_dan_bahans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kelas',25);
            $table->dateTime('tgl_pinjam')->require();
            $table->dateTime('tgl_selesai')->require();
            $table->string('pic',75);
            $table->enum('status',['terkirim','ditolak','di prosess','selesai'])->default('terkirim');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_alat_dan_bahans');
    }
};
