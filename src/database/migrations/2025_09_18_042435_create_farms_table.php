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
            $table->string('name', 50)->comment('ファーム名');
            $table->string('phone_number', 15)->unique()->nullable()->comment('電話番号');
            $table->string('email', 50)->unique()->nullable()->comment('メールアドレス');
            $table->string('street_address', 100)->comment('ストリート名');
            $table->string('suburb', 50)->comment('サバーブ名');
            $table->foreignId('state_id')->constrained()->comment('州名');
            $table->char('postcode', 4)->comment('郵便番号');
            $table->text('description')->nullable()->comment('ファームの説明文');
            $table->foreignId('created_user_id')->constrained('users')->comment('作成者');
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
