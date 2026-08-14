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
        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Agramas
            $table->string('domain')->nullable(); // Untuk fetch logo clearbit
            $table->string('logo')->nullable();
            $table->decimal('rating', 3, 1)->default(4.5); // Contoh: 4.8
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
