<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutPlan extends Model
{
    protected $fillable = ['user_id', 'name', 'day_of_week', 'muscle_groups', 'description'];

    protected $casts = [
        'muscle_groups' => 'array',
    ];

    private const DAY_LABELS = [
        'sunday' => 'Sunday', 'monday' => 'Monday', 'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday',
    ];

    private const MUSCLE_GROUP_LABELS = [
        'chest' => 'Chest', 'back' => 'Back', 'legs' => 'Legs', 'shoulders' => 'Shoulders',
        'arms' => 'Arms', 'core' => 'Core', 'full_body' => 'Full body', 'cardio' => 'Cardio', 'other' => 'Other',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function planExercises(): HasMany
    {
        return $this->hasMany(WorkoutPlanExercise::class)->orderBy('position');
    }

    /**
     * Day-of-week options for a <select>, starting on the locale's natural first day of the week.
     *
     * @return array<string, string>
     */
    public static function dayOptions(): array
    {
        $order = app()->getLocale() === 'fa'
            ? ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']
            : ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        $options = [];
        foreach ($order as $day) {
            $options[$day] = __(self::DAY_LABELS[$day]);
        }

        return $options;
    }

    /**
     * @return array<string, string>
     */
    public static function muscleGroupOptions(): array
    {
        $options = [];
        foreach (self::MUSCLE_GROUP_LABELS as $key => $label) {
            $options[$key] = __($label);
        }

        return $options;
    }

    protected function dayLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->day_of_week ? __(self::DAY_LABELS[$this->day_of_week] ?? $this->day_of_week) : null,
        );
    }

    protected function muscleGroupLabels(): Attribute
    {
        return Attribute::make(
            get: fn () => collect($this->muscle_groups ?? [])
                ->map(fn ($key) => __(self::MUSCLE_GROUP_LABELS[$key] ?? $key))
                ->values()
                ->all(),
        );
    }
}
