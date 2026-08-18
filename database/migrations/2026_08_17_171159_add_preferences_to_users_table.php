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
        Schema::table('users', function (Blueprint $table) {
            $table->string('locale', 5)->nullable()->after('password');
            $table->string('date_format')->default('gregorian')->after('locale');
            $table->string('weight_unit')->default('kg')->after('date_format');
            $table->string('theme')->default('default')->after('weight_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['locale', 'date_format', 'weight_unit', 'theme']);
        });
    }
};
