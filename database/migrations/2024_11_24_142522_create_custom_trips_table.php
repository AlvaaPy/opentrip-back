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
        Schema::create('custom_trips', function (Blueprint $table) {
            $table->id('customID');
            $table->unsignedBigInteger('userID');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('jumlah_peserta');
            $table->unsignedBigInteger('tripID')->nullable();
            $table->enum('jenis_custom',['Individu', 'Perusahaan', 'Sekolah', 'Universitas']);
            $table->unsignedBigInteger('cityID');
            $table->text('alamat_detail');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // ForeingKey
            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
            $table->foreign('tripID')->references('tripID')->on('package_trip')->onDelete('set null');
            $table->foreign('cityID')->references('cityID')->on('cities')->onDelete('cascade');
            // disini saya ingin membuat migration untuk custom trip isinya yang akan di input oleh user adalah "tanggal, jumlah_peserta, Data pemesan, Jenis Trip (Produk dari Package Trip, Produk Bebas), Jenis Custom (Individu, Gathering Perusahaan, Sekolah/Universitas), Meeting Point (ambil dari table cities), Alamat Detail, catatan  " tentunya custom trip ini akan membaca id dari si user yang memilih
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_trips');
    }
};
