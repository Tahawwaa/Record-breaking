<?php

namespace App\Models;

use App\Support\Preferences;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Exercise extends Model
{
    protected $fillable = ['user_id', 'name', 'categories', 'image_path'];

    protected $casts = [
        'categories' => 'array',
    ];

    /**
     * Fixed, precise exercise-type taxonomy. Every user picks from this same
     * list — it is not something users can invent, only assign to their own
     * exercises (an exercise may carry more than one).
     */
    private const CATEGORY_LABELS = [
        'strength' => 'Strength',
        'bodyweight' => 'Bodyweight',
        'stretching' => 'Stretching & mobility',
        'cardio' => 'Cardio',
        'powerlifting' => 'Powerlifting',
        'olympic_weightlifting' => 'Olympic weightlifting',
        'plyometric' => 'Plyometric',
        'compound' => 'Compound',
        'isolation' => 'Isolation',
        'balance' => 'Balance & core stability',
    ];

    /**
     * @return array<string, string>
     */
    public static function categoryOptions(): array
    {
        $options = [];
        foreach (self::CATEGORY_LABELS as $key => $label) {
            $options[$key] = __($label);
        }

        return $options;
    }

    protected function categoryLabels(): Attribute
    {
        return Attribute::make(
            get: fn () => collect($this->categories ?? [])
                ->map(fn ($key) => __(self::CATEGORY_LABELS[$key] ?? $key))
                ->values()
                ->all(),
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image_path ? Storage::disk('public')->url($this->image_path) : null,
        );
    }

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
