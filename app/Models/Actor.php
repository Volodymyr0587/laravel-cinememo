<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actor extends Model
{
    use HasImages;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'biography',
        'birth_date',
        'death_date',
        'birth_place',
        'death_place',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contentItems(): BelongsToMany
    {
        return $this->belongsToMany(ContentItem::class, 'actor_content_item');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($actor) {
            if ($actor->isDirty('name')) {
                $slug = Str::slug($actor->name);

                // Робимо slug унікальним
                $originalSlug = $slug;
                $counter = 1;
                while (static::where('slug', $slug)
                    ->where('id', '!=', $actor->id)
                    ->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $actor->slug = $slug;
            }
        });
    }

    /**
     * Age in years (from birth_date to death_date or today).
     */
    protected function age(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->birth_date) {
                    return null;
                }

                $endDate = $this->death_date ?? now();

                return floor($this->birth_date->diffInYears($endDate));
            },
        );
    }

    /**
     * Example: "1967– (57 years)" or "1967–2020 (53 years)".
     */
    protected function formattedAge(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->birth_date
                ? ($this->death_date
                    ? $this->birth_date->year . '–' . $this->death_date->year . ' (' . $this->age . ' ' . __('years') . ')'
                    : $this->birth_date->year . '– ... (' . $this->age . ' ' . __('years') . ')'
                )
                : null,
        );
    }

     // Helper method to get display name with distinguishing info
    public function getDisplayNameAttribute(): string
    {
        $displayName = $this->name;

        // Add birth year if available to distinguish actors with same name
        if ($this->birth_date) {
            $displayName .= ' (' . $this->birth_date->format('M-d-Y') . ')';
        }

        // If still not unique within user's actors, add birth place
        $sameNameActors = static::where('user_id', $this->user_id)
                               ->where('name', $this->name)
                               ->where('id', '!=', $this->id)
                               ->count();

        if ($sameNameActors > 0 && $this->birth_place) {
            $displayName .= ' - ' . $this->birth_place;
        }

        return $displayName;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'death_date' => 'date',
        ];
    }
}
