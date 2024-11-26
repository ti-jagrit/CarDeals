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
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('Seats')->nullable();
            $table->string('Transmission')->nullable();
            $table->string('Owner_Type')->nullable();
            $table->decimal('Power', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['Seats', 'Transmission', 'Owner_Type', 'Power']);
        });
    }
};
