<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('mongo_id', 24)->unique()->index();
            $table->integer('almirqab_id')->index()->nullable();

            $table->string('title');
            $table->unsignedSmallInteger('order')
            ->default(0)
                ->index();

            $table->timestamps();

            $table->unique('title');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
