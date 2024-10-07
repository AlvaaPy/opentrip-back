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
        Schema::create('admin', function (Blueprint $table) {
            $table->id('adminID'); // PK AI (Primary Key, Auto Increment)
            $table->string('username')->unique(); // Username, assumed to be unique
            $table->string('password'); // Password
            $table->string('name'); // Name of the admin
            $table->timestamps(); // For created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
