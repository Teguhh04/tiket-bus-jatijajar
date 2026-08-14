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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operator_id')->constrained()->onDelete('cascade');
            $table->foreignId('origin_id')->constrained('terminals')->onDelete('cascade');
            $table->foreignId('destination_id')->constrained('terminals')->onDelete('cascade');
            $table->string('bus_class');
            $table->json('facilities');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->string('duration');
            $table->integer('price');
            $table->integer('available_seats');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
