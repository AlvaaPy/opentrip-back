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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id('rentalID');
            $table->string('nama_kendaraan');
            $table->integer('kapasitas_kendaraan');
            $table->integer('kapasitas_bagasi');
            $table->integer('umur_kendaraan');
            $table->enum('jenis_kendaraan', ['metic', 'automatic']);
            $table->text('deskripsi')->nullable();
            $table->enum('dengan_supir', ['ya', 'tidak'])->default('tidak');
            $table->decimal('harga', 10, 2); // Maks 10 digit, 2 desimal
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
