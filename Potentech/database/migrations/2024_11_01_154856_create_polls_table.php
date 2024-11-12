<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('room_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('question');
            $table->json('options'); // Store options as JSON
            $table->integer('time_limit'); // in seconds
            $table->timestamps();
        });


        Schema::create('poll_responses', function (Blueprint $table) {
            $table->id();
            $table->string('poll_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polls');
        Schema::dropIfExists('poll_responses');
    }
};
