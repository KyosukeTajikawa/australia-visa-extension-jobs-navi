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
        Schema::create('farm_crops', function (Blueprint $table) {
            $table->foreignId('farm_id')->constrained()->onDelete('cascade')->comment('ファームID');
            $table->foreignId('crop_id')->constrained()->onDelete('cascade')->comment('作物ID');

            $table->primary(['farm_id', 'crop_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_crops');
    }
};
