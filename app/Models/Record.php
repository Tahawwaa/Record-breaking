<?php

namespace App\Models;

use App\Support\Preferences;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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
            get: fn () => Preferences::formatWeight((float) $this->weight),
        );
    }

    protected function dateLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => Preferences::formatDate($this->date),
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
            ->whereHas('exercise', fn ($query) => $query->where('user_id', Auth::id()))
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
