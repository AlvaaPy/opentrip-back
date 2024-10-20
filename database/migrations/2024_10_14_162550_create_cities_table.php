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
        Schema::create('cities', function (Blueprint $table) {
            $table->id('cityID'); // Primary Key
            $table->unsignedBigInteger('countryID'); // Foreign key ke countries
            $table->unsignedBigInteger('provinceID'); // Foreign key ke provinces
            $table->string('city_name', 255); // Nama kota
            $table->timestamps(); // Timestamps (created_at & updated_at)

            // Mendefinisikan foreign key untuk provinceID
            $table->foreign('provinceID')->references('provinceID')->on('provinces')->onDelete('cascade');

            // Mendefinisikan foreign key untuk countryID
            $table->foreign('countryID')->references('countryID')->on('countries')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
