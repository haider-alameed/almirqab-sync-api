<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('mongo_id', 24)->unique()->index();
            $table->integer('almirqab_id')->index()->nullable();

            $table->string('name');
            $table->string('postfix')->nullable();
            $table->string('full_title');
            $table->unsignedBigInteger('school_id');
            $table->string('name_en')->nullable();
            $table->string('full_title_en')->nullable();

            $table->decimal('fee', 10, 2)->nullable();

            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
