<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('mongo_id', 24)->unique()->index();
            $table->foreignId('person_id')->constrained('persons')->cascadeOnDelete();
            $table->foreignId('year_id')->index()->constrained('persons')->cascadeOnDelete()->nullable();
            $table->boolean('migrated')->default(false);
            $table->unsignedTinyInteger('app_state')->default(1);
            $table->dateTime('state_date')->nullable();
//this column from teachers plain
            $table->string('mongo_id', 24)->nullable()->unique()->index();
            $table->string('user_code', 50)->nullable()->index();
            $table->string('nfc_id', 50)->nullable()->index();
            $table->string('nfc_number', 50)->nullable();
            $table->string('default_password')->nullable();

            $table->string('image')->nullable();
            $table->string('academic')->nullable();
            $table->tinyInteger('gender')->nullable()->index();
            $table->boolean('user_api')->default(false);
            $table->boolean('is_manager')->default(false);
            $table->boolean('teacher_in_api')->default(false);
            $table->string('role')->default('user')->index();
            $table->boolean('active')->default(true)->index();
            $table->string('daily_plan_type')->nullable();
            $table->timestamp('mongo_created_at')->nullable();
            $table->timestamp('mongo_updated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
