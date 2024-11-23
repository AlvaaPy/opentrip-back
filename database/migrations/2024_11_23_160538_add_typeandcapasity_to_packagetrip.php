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
        Schema::table('package_trip', function (Blueprint $table) {
            //
            $table->enum('trip_type', ['open', 'private']); 
            
            // Mengubah kapasitas menjadi integer
            $table->integer('capacity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_trip', function (Blueprint $table) {
            //
            $table->dropColumn(['trip_type', 'capacity']);
        });
    }
};
