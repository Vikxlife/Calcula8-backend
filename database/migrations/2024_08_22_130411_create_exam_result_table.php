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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->string('exam_type');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('question_id');
            $table->integer('answered')->default(0);
            $table->integer('correct')->default(0);
            $table->integer('incorrect')->default(0);
            $table->integer('skipped')->default(0);
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
        Schema::dropIfExists('exam_results');
    }
};
