<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('workout_plans', function (Blueprint $table) {
            $table->json('muscle_groups')->nullable()->after('muscle_group');
        });

        DB::table('workout_plans')->whereNotNull('muscle_group')->orderBy('id')->each(function ($plan) {
            DB::table('workout_plans')->where('id', $plan->id)->update([
                'muscle_groups' => json_encode([$plan->muscle_group]),
            ]);
        });

        Schema::table('workout_plans', function (Blueprint $table) {
            $table->dropColumn('muscle_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workout_plans', function (Blueprint $table) {
            $table->string('muscle_group')->nullable()->after('day_of_week');
        });

        DB::table('workout_plans')->whereNotNull('muscle_groups')->orderBy('id')->each(function ($plan) {
            $groups = json_decode($plan->muscle_groups, true) ?? [];
            DB::table('workout_plans')->where('id', $plan->id)->update([
                'muscle_group' => $groups[0] ?? null,
            ]);
        });

        Schema::table('workout_plans', function (Blueprint $table) {
            $table->dropColumn('muscle_groups');
        });
    }
};
