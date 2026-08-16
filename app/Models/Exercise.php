<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = ['name'];

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
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
            return 'No change this month';
        }

        $diff = (float) $thisMonth->last()->weight - (float) $thisMonth->first()->weight;

        if ($diff === 0.0) {
            return 'No change this month';
        }

        $formatted = rtrim(rtrim(number_format(abs($diff), 2), '0'), '.');

        return $diff > 0 ? "+{$formatted} lb this month" : "-{$formatted} lb this month";
    }
}
