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
        Schema::create('user_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->comment('ユーザー写真が紐づくファームID');
            $table->string('url', 500)->unique()->comment('画像URL');
            $table->string('path')->unique()->comment('画像パス');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_images', function (Blueprint $table) {
            $table->dropForeign('[user_id]');
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('farm_images');
    }
};
