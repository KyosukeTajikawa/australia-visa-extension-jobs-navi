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
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('street_address', 100);
            $table->string('suburb', 50);
            $table->foreignId('state_id')->constrained();
            $table->char('postcode', 4);
            $table->text('description')->nullable();
            $table->foreignId('created_user_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');
            $table->dropForeign(['created_user_id']);
            $table->dropColumn('created_user_id');
        });

        Schema::dropIfExists('farms');
    }
};
