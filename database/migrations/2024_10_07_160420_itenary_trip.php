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
        Schema::create('itenary_trip', function (Blueprint $table) {
            $table->id('itenaryID'); 
            $table->unsignedBigInteger('tripID'); // Tipe data harus sama dengan tripID di package_trip
            $table->integer('hari_ke'); 
            $table->text('deskripsi'); 
            $table->time('waktu_mulai'); 
            $table->time('waktu_selesai'); 
            $table->timestamps(); 
            
            // Mendefinisikan foreign key
            $table->foreign('tripID')->references('tripID')->on('package_trip')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itenary_trip');
    }
};
