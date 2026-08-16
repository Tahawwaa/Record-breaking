<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Record extends Model
{
    protected $fillable = ['exercise_id', 'weight', 'reps', 'set_number', 'date'];

    protected function casts(): array
    {
        return [
            'weight' => 'decimal:2',
            'date' => 'date',
        ];
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    protected function weightLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => rtrim(rtrim(number_format((float) $this->weight, 2), '0'), '.'),
        );
    }

    /**
     * All records ordered oldest to newest, each flagged with is_pr: true the
     * first time an exercise's weight surpasses every earlier attempt.
     */
    public static function withPersonalRecords(): Collection
    {
        $runningMax = [];

        return static::with('exercise')
            ->orderBy('date')
            ->orderBy('id')
            ->get()
            ->map(function (self $record) use (&$runningMax) {
                $previousMax = $runningMax[$record->exercise_id] ?? 0.0;
                $record->is_pr = (float) $record->weight > $previousMax;
                $runningMax[$record->exercise_id] = max($previousMax, (float) $record->weight);

                return $record;
            });
    }
}
