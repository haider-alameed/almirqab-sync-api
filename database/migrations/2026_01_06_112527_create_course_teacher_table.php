<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_teacher', function (Blueprint $table) {
            $table->id();
            $table->string('mongo_id', 24)->unique()->index();
            $table->integer('almirqab_id')->index()->nullable();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id');

             $table->unsignedBigInteger('year_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
            // prevent duplicates
            $table->unique(['course_id', 'teacher_id']);

            $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();

            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();

            // Optional if you add year_id:
             $table->foreign('year_id')->references('id')->on('years')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('course_teacher', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['year_id']);
        });

        Schema::dropIfExists('course_teacher');
    }
};
