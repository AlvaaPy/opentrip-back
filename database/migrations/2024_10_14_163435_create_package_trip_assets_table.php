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
        Schema::create('package_trip_assets', function (Blueprint $table) {
            $table->id(); // Primary Key otomatis
            $table->unsignedBigInteger('tripID'); // Foreign key dari package_trip
            $table->string('picture', 255); // Nama gambar atau URL gambar
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
        Schema::dropIfExists('package_trip_assets');
    }
};
