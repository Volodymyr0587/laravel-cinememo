<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function contentTypes(): HasMany
    {
        return $this->hasMany(ContentType::class);
    }

    public function contentItems(): HasMany
    {
        return $this->hasMany(ContentItem::class);
    }

    /**
     * Get all of the people for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    /**
     * Get all of the Articles for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function getCinemaLevelAttribute(): array
    {
        $count = $this->contentItems()->count();

        $levels = [
            ['min' => 101, 'label' => __('dashboard.levels.master'),     'badge' => '🎥'],
            ['min' => 51,  'label' => __('dashboard.levels.archivist'),  'badge' => '🏆'],
            ['min' => 26,  'label' => __('dashboard.levels.cinephile'),  'badge' => '🌟'],
            ['min' => 11,  'label' => __('dashboard.levels.enthusiast'), 'badge' => '🍿'],
            ['min' => 1,   'label' => __('dashboard.levels.beginner'),   'badge' => '🎬'],
        ];

        // Find current level
        foreach ($levels as $index => $level) {
            if ($count >= $level['min']) {
                $next = $levels[$index - 1] ?? null; // <-- immediate higher level
                $toNext = $next ? $next['min'] - $count : null;

                return [
                    'level' => $level['label'],
                    'badge' => $level['badge'],
                    'count' => $count,
                    'nextLevel' => $next['label'] ?? null,
                    'toNext' => $toNext,
                    'min' => $level['min'],
                    'max' => $next['min'] ?? $count,
                ];
            }
        }

        // No items yet
        return [
            'level' => null,
            'badge' => null,
            'count' => 0,
            'nextLevel' => __('dashboard.levels.beginner'),
            'toNext' => 1,
            'min' => 0,
            'max' => 1,
        ];
    }

    public function getCinemaLevelsAttribute(): array
    {
        $count = $this->contentItems()->count();

        $levels = [
            ['min' => 1,   'label' => __('dashboard.levels.beginner'),   'badge' => '🎬'],
            ['min' => 11,  'label' => __('dashboard.levels.enthusiast'), 'badge' => '🍿'],
            ['min' => 26,  'label' => __('dashboard.levels.cinephile'),  'badge' => '🌟'],
            ['min' => 51,  'label' => __('dashboard.levels.archivist'),  'badge' => '🏆'],
            ['min' => 101, 'label' => __('dashboard.levels.master'),     'badge' => '🎥'],
        ];

        $currentLevel = $this->cinema_level['level'];

        return collect($levels)->map(function ($level) use ($count, $currentLevel) {
            return [
                'label' => $level['label'],
                'badge' => $level['badge'],
                'min' => $level['min'],
                'unlocked' => $count >= $level['min'],
                'current' => $level['label'] === $currentLevel,
            ];
        })->toArray();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if (! $user->contentTypes()->where('name', 'movie')->exists()) {
                $user->contentTypes()->create([
                    'name' => 'movie',
                    'color' => '#ff9900',
                ]);
            }
        });
    }
}
