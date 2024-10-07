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
        Schema::create('package_trip', function (Blueprint $table) {
            $table->id('tripID'); 
            $table->string('namaTrip'); 
            $table->string('provinsi'); 
            $table->string('kota'); 
            $table->text('alamat'); 
            $table->text('deskripsi'); 
            $table->string('meeting_point'); 
            $table->decimal('price', 10, 2); 
            $table->date('start_date'); 
            $table->date('end_date'); 
            $table->decimal('rating', 3, 2)->nullable(); 
            $table->timestamps(); // Timestamps (created_at & updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_trip');
    }
};
