<?php

namespace App\Models;

use App\Support\Preferences;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Exercise extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }

    /**
     * Finds an exercise by name within the current user's own list, ignoring
     * case, creating it if none exists. Prevents "Bench Press" and
     * "bench press" from becoming separate rows.
     */
    public static function findOrCreateByName(string $name): self
    {
        return static::where('user_id', Auth::id())
            ->whereRaw('LOWER(name) = ?', [mb_strtolower($name)])
            ->first()
            ?? static::create(['user_id' => Auth::id(), 'name' => $name]);
    }

    /**
     * The heaviest record ever logged for this exercise.
     * Requires the `records` relation to already be loaded.
     */
    public function bestRecord(): ?Record
    {
        return $this->records->sortByDesc('weight')->first();
    }

    /**
     * Human-readable weight change across this exercise's records logged this month.
     * Requires the `records` relation to already be loaded.
     */
    public function monthlyTrendLabel(): string
    {
        $thisMonth = $this->records
            ->filter(fn (Record $record) => $record->date->isSameMonth(now()))
            ->sortBy('date')
            ->values();

        if ($thisMonth->count() < 2) {
            return __('No change this month');
        }

        $diffKg = (float) $thisMonth->last()->weight - (float) $thisMonth->first()->weight;

        if ($diffKg === 0.0) {
            return __('No change this month');
        }

        $unit = Preferences::weightUnit();
        $formatted = Preferences::formatWeight(abs($diffKg));
        $sign = $diffKg > 0 ? '+' : '-';

        // Isolated so the sign+number don't get bidi-reordered inside RTL text (e.g. Persian).
        $amount = '<bdi dir="ltr">'.e("{$sign}{$formatted} {$unit}").'</bdi>';

        return __(':amount this month', ['amount' => $amount]);
    }
}
