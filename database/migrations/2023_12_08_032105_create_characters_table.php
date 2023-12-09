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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 1024)->default('John Smith');
            $table->string('race', 64)->nullable();
            $table->string('class', 64)->nullable();
            $table->mediumText('biography')->nullable();
            $table->string('origin', 64)->nullable();
            $table->string('email', 256)->nullable();
            $table->string('font_color', 64)->nullable()->default('black');
            $table->string('img', 1024)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
