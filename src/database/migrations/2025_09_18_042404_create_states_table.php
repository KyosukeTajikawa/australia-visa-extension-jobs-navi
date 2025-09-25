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
<<<<<<< HEAD
        Schema::create('states', function (Blueprint $table)
    {
            $table->id();
            $table->string('name', 50)->unique()->comment('州名');
    }
    }
=======
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
        });
    }

>>>>>>> 102594d (マイグレーションファイル・テーブル作成)
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<< HEAD
        Schema::table(
            'states',function (Blueprint $table) {
        Schema::dropIfExists('states');    }
}
=======
        Schema::dropIfExists('states');
    }
>>>>>>> 102594d (マイグレーションファイル・テーブル作成)
};
