<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->text('correct_answer')->nullable();
            $table->json('multiple_question_option')->nullable();
            $table->text('fill_in_the_blank')->nullable();
            $table->longText('essay')->nullable();
            $table->foreignId('quiz_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_answers');
    }
};
