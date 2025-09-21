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
<<<<<<< HEAD
            $table->string('work_position', 50)->comment('仕事のポジション');
            $table->decimal('hourly_wage', 3, 1)->unsigned()->nullable()->comment('時給'); //小数点第1位まで
            $table->date('start_date')->comment('開始日');
            $table->date('end_date')->nullable()->comment('終了日');
            $table->tinyInteger('work_rating')->unsigned()->comment('仕事内容の評価'); //1~5で評価
            $table->tinyInteger('salary_rating')->unsigned()->comment('給料の評価'); //1~5で評価
            $table->tinyInteger('hour_rating')->unsigned()->comment('労働時間の評価'); //1~5で評価
            $table->tinyInteger('relation_rating')->unsigned()->comment('人間関係の評価'); //1~5で評価
            $table->tinyInteger('overall_rating')->unsigned()->comment('総合評価'); //1~5で評価
            $table->text('comment')->comment('自由記述欄');
            $table->tinyInteger('pay_type')->unsigned()->comment('支払種別'); //1=hourly,2=pieerate
            $table->tinyInteger('is_car_required')->unsigned()->comment('車が必要か否か'); //1=必要,2=不要
            $table->foreignId('user_id')->constrained()->comment('レビュー投稿者');
            $table->foreignId('farm_id')->constrained()->comment('レビューが紐づくファームID');
=======
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
            $table->foreignId('farm_id')->constrained();
>>>>>>> 75a7975 (controller route 作成)
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
