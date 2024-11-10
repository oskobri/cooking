<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->index()->after('id');
            $table->after('kcal', function (Blueprint $table) {
                $table->boolean('public')->default(false);
                $table->boolean('published')->default(true);
            });
        });
    }

    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('public');
            $table->dropColumn('published');
        });
    }
};
