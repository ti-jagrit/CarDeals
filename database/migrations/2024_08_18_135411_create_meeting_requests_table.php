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
        Schema::create('meeting_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade'); // Seller user ID
            $table->foreignId('requested_by_id')->constrained('users')->onDelete('cascade'); // Requested by user ID
            $table->string('status')->default('Pending');
            $table->text('description')->nullable();
            $table->text('rejection_details')->nullable();
            $table->date('meeting_date');
            $table->boolean('visibility')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_requests');
    }
};
