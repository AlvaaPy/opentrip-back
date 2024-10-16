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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id('provinceID'); 
            $table->unsignedBigInteger('countryID');
            $table->string('province_name', 255); // Nama provinsi
            $table->timestamps(); // Timestamps (created_at & updated_at)

            $table->foreign('countryID')->references('countryID')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
