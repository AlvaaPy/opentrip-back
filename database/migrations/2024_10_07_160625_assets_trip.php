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
        Schema::create('assets_trip', function (Blueprint $table) {
            $table->id('assetsID'); 
            $table->unsignedBigInteger('tripID'); // Tipe data harus sama dengan tripID di package_trip
            $table->text('images')->nullable(); 
            $table->text('video')->nullable(); 
            $table->timestamps(); // Timestamps
            
            // Mendefinisikan foreign key
            $table->foreign('tripID')->references('tripID')->on('package_trip')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets_trip');
    }
};
