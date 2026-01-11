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
        Schema::create('review_mail_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('コメントが届いたレビューを作成したユーザーID');
            $table->foreignId('review_id')->constrained()->onDelete('cascade')->comment('コメントが届いたレビューID');

            // 送信状態
            $table->timestamp('sent_at')->nullable()->comment('送信時間');
            $table->timestamp('failed_at')->nullable()->comment('失敗時間');
            $table->text('last_error')->nullable()->comment('送信失敗のエラー内容');
            $table->timestamps();

            $table->unique(['user_id', 'review_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_mail_badges');
    }
};
