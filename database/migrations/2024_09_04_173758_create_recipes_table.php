<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('picture')->nullable();
            $table->string('url')->nullable();
            $table->string('source')->nullable();
            $table->text('instructions')->nullable();
            $table->unsignedSmallInteger('preparation_time')->nullable();
            $table->unsignedSmallInteger('total_time')->nullable();
            $table->unsignedSmallInteger('kcal')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
