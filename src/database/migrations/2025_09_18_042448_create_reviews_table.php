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
            $table->string('work_position', 50)->comment('仕事のポジション');
            $table->decimal('hourly_wage', 3, 1)->unsigned()->nullable()->comment('時給'); //小数点第1位まで
            $table->tinyInteger('pay_type')->unsigned()->comment('支払種別（1=時給、2=出来高制）');
            $table->tinyInteger('is_car_required')->unsigned()->comment('車の有無(1=必要,2=不要)');
            $table->date('start_date')->comment('開始日');
            $table->date('end_date')->nullable()->comment('終了日');
            $table->tinyInteger('work_rating')->unsigned()->comment('仕事内容の評価'); //1~5で評価
            $table->tinyInteger('salary_rating')->unsigned()->comment('給料の評価'); //1~5で評価
            $table->tinyInteger('hour_rating')->unsigned()->comment('労働時間の評価'); //1~5で評価
            $table->tinyInteger('relation_rating')->unsigned()->comment('人間関係の評価'); //1~5で評価
            $table->tinyInteger('overall_rating')->unsigned()->comment('総合評価'); //1~5で評価
            $table->text('comment')->nullable()->comment('自由記述欄');
            $table->foreignId('user_id')->constrained()->comment('レビュー投稿者');
            $table->foreignId('farm_id')->constrained()->comment('レビューが紐づくファームID');
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
