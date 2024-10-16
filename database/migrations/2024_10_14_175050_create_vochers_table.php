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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('voucherID'); 
            $table->string('voucher_code')->unique(); 
            $table->string('picture')->nullable(); 
            $table->decimal('fixed_discount', 10, 2)->nullable(); 
            $table->decimal('percentage_discount', 5, 2)->nullable(); 
            $table->enum('voucher_type', ['general', 'specific']); 
            $table->unsignedBigInteger('tripID')->nullable(); 
            $table->date('valid_from')->nullable(); 
            $table->date('valid_until')->nullable(); 
            $table->boolean('is_active')->default(true); 
            $table->timestamps(); 

            // Mendefinisikan foreign key jika tripID diisi
            $table->foreign('tripID')->references('tripID')->on('package_trip')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
