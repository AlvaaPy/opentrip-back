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
            $table->unsignedBigInteger('provinceID');
            $table->string('city_name', 255); // Nama kota
            $table->timestamps(); // Timestamps (created_at & updated_at)

            $table->foreign('provinceID')->references('provinceID')->on('provinces')->onDelete('cascade');
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
