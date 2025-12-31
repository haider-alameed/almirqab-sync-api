<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('mongo_id', 24);
            $table->string("name")->index();
            $table->string("image")->nullable();
            $table->string("closest_point")->nullable();
            $table->string("manager_name")->index()->nullable();
            $table->string("manager_phone")->nullable();
            $table->string("directorate")->nullable();
            $table->string("governorate")->nullable();
            $table->string("group_name")->index()->nullable();//from plain
            $table->string("gander")->index()->nullable();//from plain
            $table->string("active")->index()->nullable();//from plain
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
