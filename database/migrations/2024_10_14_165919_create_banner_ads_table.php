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
        Schema::create('banner_ads', function (Blueprint $table) {
            $table->id('bannerID'); // Primary Key dengan AI (Auto Increment)
            $table->string('banner_assets'); // Nama file atau URL untuk aset banner
            $table->text('description'); // Deskripsi banner
            $table->timestamps(); // Timestamps (created_at & updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_ads');
    }
};
