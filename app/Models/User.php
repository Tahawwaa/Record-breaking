<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'username', 'phone', 'email', 'password', 'locale', 'date_format', 'weight_unit', 'theme', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Gate access to the /admin panel — same login/session as the rest of the
     * site, just an extra check on top (see AdminPanelProvider, which also
     * disables Filament's own login page in favor of the app's one).
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }

    protected static function booted(): void
    {
        // The exercises row cascades on delete at the DB level, which skips Eloquent
        // events — so uploaded photo files would otherwise be orphaned on disk. This
        // runs for every deletion path (self-service and the admin panel alike),
        // since both ultimately call Eloquent's delete().
        static::deleting(function (self $user) {
            Exercise::where('user_id', $user->id)->whereNotNull('image_path')->get()
                ->each(fn (Exercise $exercise) => Storage::disk('public')->delete($exercise->image_path));
        });
    }
}
