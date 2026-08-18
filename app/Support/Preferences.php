<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class Preferences
{
    private const KG_PER_LB = 0.45359237;

    /**
     * Render a date per the user's calendar preference (Gregorian or Jalali).
     */
    public static function formatDate(Carbon $date, ?User $user = null): string
    {
        $user ??= Auth::user();

        if ($user?->date_format === 'jalali') {
            return Jalalian::fromCarbon($date)->format('j F Y');
        }

        return $date->format('M j, Y');
    }

    /**
     * Same as formatDate() but without the year, for compact contexts like chart axes.
     */
    public static function formatShortDate(Carbon $date, ?User $user = null): string
    {
        $user ??= Auth::user();

        if ($user?->date_format === 'jalali') {
            return Jalalian::fromCarbon($date)->format('j M');
        }

        return $date->format('M j');
    }

    public static function weightUnit(?User $user = null): string
    {
        $user ??= Auth::user();

        return $user?->weight_unit === 'lb' ? 'lb' : 'kg';
    }

    /**
     * Convert a kg value (as stored) to the user's preferred display unit.
     */
    public static function weightToDisplay(float $kg, ?User $user = null): float
    {
        return static::weightUnit($user) === 'lb' ? $kg / self::KG_PER_LB : $kg;
    }

    /**
     * Convert a value entered in the user's preferred unit back to kg for storage.
     */
    public static function weightToKg(float $value, ?User $user = null): float
    {
        return static::weightUnit($user) === 'lb' ? $value * self::KG_PER_LB : $value;
    }

    /**
     * Format a kg value for display, trimmed of trailing zeros, without the unit suffix.
     */
    public static function formatWeight(float $kg, ?User $user = null): string
    {
        $value = static::weightToDisplay($kg, $user);

        return rtrim(rtrim(number_format($value, 2), '0'), '.');
    }
}
