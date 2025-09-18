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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('work_position', 50);
            $table->decimal('wage', 3, 1)->unsigned()->nullable(); //小数点第1位まで
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->tinyInteger('work_rating')->unsigned(); //1~5で評価
            $table->tinyInteger('salary_rating')->unsigned(); //1~5で評価
            $table->tinyInteger('hour_rating')->unsigned(); //1~5で評価
            $table->tinyInteger('relation_rating')->unsigned(); //1~5で評価
            $table->tinyInteger('overall_rating')->unsigned(); //1~5で評価
            $table->text('comment');
            $table->tinyInteger('pay_type')->unsigned(); //1=hourly,2=pieerate
            $table->tinyInteger('is_car_required')->unsigned(); //1=必要,2=不要
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews', function (Blueprint $table) {
            $table->dropForeign('[user_id]');
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('reviews');
    }
};
