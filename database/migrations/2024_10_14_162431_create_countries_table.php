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
            Schema::create('countries', function (Blueprint $table) {
                $table->id('countryID'); // Primary Key
                $table->string('country_name', 255); // Nama negara
                $table->timestamps(); // Timestamps (created_at & updated_at)
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('countries');
        }
    };
