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
        Schema::create('farm_mail_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('ユーザーID');
            $table->foreignId('farm_id')->constrained()->onDelete('cascade')->comment('ファームID');

            //送信状態
            $table->timestamp('send_at')->nullable()->comment('送信時間');
            $table->timestamp('failed_at')->nullable()->comment('失敗時間');
            $table->text('last_error')->nullable()->comment('メール送信失敗時のエラーメッセージ');

            $table->timestamps();

            $table->unique(['user_id', 'farm_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_mail_badges');
    }
};
