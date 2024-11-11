<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->index(['name'], 'recipes_name_index');
            $table->fullText('name', 'recipes_name_fulltext_index');
            $table->index(['published', 'public', 'user_id', 'deleted_at', 'name'], 'recipes_search_index');

        });
        Schema::table('ingredients', function (Blueprint $table) {
            $table->index(['name'], 'ingredients_name_index');
            $table->fullText('name', 'ingredients_name_fulltext_index');
        });
    }

    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropIndex('recipes_name_index');
            $table->dropIndex('recipes_name_fulltext_index');
            $table->dropIndex('recipes_search_index');
        });

        Schema::table('ingredients', function (Blueprint $table) {
            $table->dropIndex('ingredients_name_index');
            $table->dropIndex('ingredients_name_fulltext_index');
        });
    }
};
