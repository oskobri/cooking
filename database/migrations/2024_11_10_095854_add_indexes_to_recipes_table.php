<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            // Composite index for filtering
            $table->index(['published', 'public', 'user_id', 'deleted_at'], 'recipes_filters_index');
            $table->index(['published', 'public', 'user_id', 'deleted_at'], 'recipes_filters_index');

            // Index for sorting
            $table->index(['published', 'public', 'user_id', 'deleted_at', 'created_at'], 'recipes_sort_by_created_at_index');
            $table->index(['published', 'public', 'user_id', 'deleted_at', 'kcal'], 'recipes_sort_by_kcal_index');
            $table->index(['published', 'public', 'user_id', 'deleted_at', 'preparation_time'], 'recipes_sort_by_preparation_time_index');
            $table->index(['published', 'public', 'user_id', 'deleted_at', 'total_time'], 'recipes_sort_by_total_time_index');
            $table->index(['published', 'public', 'user_id', 'deleted_at', 'name'], 'recipes_sort_by_name_index');
        });
    }

    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropIndex('recipes_filters_index');
            $table->dropIndex('recipes_sort_by_created_at_index');
            $table->dropIndex('recipes_sort_by_kcal_index');
            $table->dropIndex('recipes_sort_by_preparation_time_index');
            $table->dropIndex('recipes_sort_by_total_time_index');
            $table->dropIndex('recipes_sort_by_name_index');
        });
    }
};
