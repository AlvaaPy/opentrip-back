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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservationID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('tripID');
            $table->integer('jumlah_peserta');
            $table->string('nama_pemesan');
            $table->string('email_pemesan');
            $table->string('no_telepon_pemesan');
            $table->string('meeting_points');
            $table->date('tgl_reservation');
            $table->date('tgl_start');
            $table->date('tgl_end');
            $table->decimal('total_harga', 10, 2);
            $table->unsignedBigInteger('voucherID')->nullable();
            $table->enum('status', ['Pending', 'Menunggu Pembayaran', 'Dibatalkan', 'Dikonfirmasi']);
            $table->timestamps();
            
            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
            $table->foreign('tripID')->references('tripID')->on('package_trip')->onDelete('cascade');
            $table->foreign('voucherID')->references('voucherID')->on('vouchers')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
