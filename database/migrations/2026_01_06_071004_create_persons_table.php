<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->integer('almirqab_id')->index()->nullable();
            $table->string('mongo_id', 24)->unique()->index();
            $table->string('full_name')->index();
            $table->date('date_of_birth')->nullable();

            $table->string('address')->nullable();
            $table->string('phone', 30)->index()->nullable();

            $table->string('code')->nullable()->unique();

            $table->unsignedTinyInteger('type')->index()->default(0);
            $table->unsignedTinyInteger('gender')->default(0);
            $table->boolean('test')->default(false);

            $table->decimal('latitude', 10, 7)->default(0);
            $table->decimal('longitude', 10, 7)->default(0);


            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
