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
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_legacy')->default(false);
            $table->boolean('top_to_bottom')->default(true);
            $table->string('language', 2)->default('en');
            $table->string('country', 2)->default('US');
            $table->string('timezone', 128)->default('America/New_York');
            $table->tinyInteger('clock_type')->default(12);
            $table->boolean('email_optin')->default(false);
            $table->string('menu_color', 64)->default('maroon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
