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
        Schema::create('farm_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->comment('ファーム写真が紐づくファームID');
            $table->string('url')->unique()->comment('画像URL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_images', function (Blueprint $table) {
            $table->dropForeign('[farm_id]');
            $table->dropColumn('farm_id');
        });

        Schema::dropIfExists('farm_images');
    }
};
