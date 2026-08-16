<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
