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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('character_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('room_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->string('character_name', 1024)->nullable();
            $table->string('character_url', 1024)->nullable();
            $table->text('message');
            $table->string('ip_address', 16)->nullable()->default('255.255.255.255');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
