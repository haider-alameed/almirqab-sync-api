<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('mongo_id', 24)->unique()->index();
            $table->integer('almirqab_id')->index()->nullable();

            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('supervisor_id')->nullable();

            $table->string('title');
            $table->string('class_title');
            $table->string('full_title');

            // These are usually derived, but if you want to store them:
            $table->unsignedInteger('students_count')->default(0);
            $table->unsignedInteger('timetable_count')->default(0);

            $table->timestamps();

            // Indexes + FKs
            $table->index('stage_id');
            $table->index('supervisor_id');

            $table->foreign('stage_id')->references('id')->on('stages')->cascadeOnDelete();

            $table->foreign('supervisor_id')->references('id')->on('teachers')->nullOnDelete();


            $table->unique(['stage_id', 'title']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
