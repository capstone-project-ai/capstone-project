<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->string('quiz_id')->nullable(); // Link to quizzes
            $table->string('user_id')->nullable(); // Link to users
            $table->integer('question_id'); // This can be the ID of the question in the quiz
            $table->text('user_answer'); // User's answer
            $table->boolean('is_correct')->default(false); // Flag for correct/incorrect
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
