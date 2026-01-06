<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('weekly_timetables', function (Blueprint $table) {

            $table->id();
            $table->string('mongo_id', 24)->unique()->index();
            $table->integer('almirqab_id')->index()->nullable();

            $table->unsignedTinyInteger('day');   // 1..5
            $table->unsignedTinyInteger('order'); // period number

            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('course_id');

            // OPTIONAL: if you want to fix a specific teacher for the slot
             $table->unsignedBigInteger('teacher_id')->nullable();

            // OPTIONAL: if timetable is per academic year
             $table->unsignedBigInteger('year_id')->nullable();

            $table->timestamps();

            // one class can't have 2 courses in same day+order
            $table->unique(['class_id', 'day', 'order'], 'weekly_unique_slot');

            $table->foreign('class_id')->references('id')->on('classes')->cascadeOnDelete();

            $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();

            // OPTIONAL foreign keys:
             $table->foreign('teacher_id')->references('id')->on('teachers')->nullOnDelete();
             $table->foreign('year_id')->references('id')->on('years')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_timetables');
    }
};
