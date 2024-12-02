<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grocery_lists', function (Blueprint $table) {
            $table->timestamp('recipe_updated_at')
                ->after('serving_count')
                ->nullable()
                ->comment('Last time a recipe was added/removed to the grocery list. To notify user when he wants to add/remove a recipe to a grocery list after a certain time.');
        });
    }

    public function down(): void
    {
        Schema::table('grocery_lists', function (Blueprint $table) {
            $table->dropColumn('recipe_updated_at');
        });
    }
};
