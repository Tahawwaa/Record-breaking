<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
            $table->string('phone')->nullable()->after('username');
            $table->string('email')->nullable()->change();
        });

        // Backfill a username for any pre-existing accounts (registration used to
        // be email-only), derived from their email/name, deduped if it collides.
        DB::table('users')->whereNull('username')->orderBy('id')->get()->each(function ($user) {
            $base = Str::slug(Str::before($user->email ?: $user->name, '@'), '_') ?: 'user'.$user->id;
            $username = $base;
            $suffix = 1;

            while (DB::table('users')->where('username', $username)->where('id', '!=', $user->id)->exists()) {
                $username = $base.($suffix++);
            }

            DB::table('users')->where('id', $user->id)->update(['username' => $username]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable(false)->change();
            $table->unique('username');
            $table->unique('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropUnique(['phone']);
            $table->dropColumn(['username', 'phone']);
            $table->string('email')->nullable(false)->change();
        });
    }
};
