<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grocery_list_recipe', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grocery_list_id')->index();
            $table->unsignedBigInteger('recipe_id')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grocery_list_recipe');
    }
};
