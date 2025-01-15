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
        Schema::create('images_rentals', function (Blueprint $table) {
            $table->id('images_rental_id');
            $table->unsignedBigInteger('rentalID'); // Foreign key dari package_trip
            $table->string('picture', 255); // Nama gambar atau URL gambar
            $table->timestamps();

            $table->foreign('rentalID')->references('rentalID')->on('rentals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images_rentals');
    }
};
