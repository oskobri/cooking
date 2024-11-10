<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grocery_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->index()->after('id');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('grocery_lists', function (Blueprint $table) {
            $table->removeColumn('user_id');
            $table->removeColumn('deleted_at');
        });
    }
};
