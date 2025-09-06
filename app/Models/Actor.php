<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function getFormattedBirthDateAttribute(): string
    {
        $date = $this->birth_date;

        if (preg_match('/^\d{4}$/', $date)) {
            return $date; // just the year, no localization needed
        }

        if (preg_match('/^\d{4}-\d{2}$/', $date)) {
            return \Carbon\Carbon::createFromFormat('Y-m', $date)
                ->locale(app()->getLocale()) // <- set locale
                ->isoFormat('YYYY MMMM'); // localized month
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $date)
                ->locale(app()->getLocale()) // <- set locale
                ->isoFormat('LL'); // localized date
        }

        return $date;
    }


    public function getFormattedDeathDateAttribute(): string
    {
        $date = $this->death_date;

        if (preg_match('/^\d{4}$/', $date)) {
            return $date; // just the year, no localization needed
        }

        if (preg_match('/^\d{4}-\d{2}$/', $date)) {
            return \Carbon\Carbon::createFromFormat('Y-m', $date)
                ->locale(app()->getLocale()) // <- set locale
                ->isoFormat('YYYY MMMM'); // localized month
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $date)
                ->locale(app()->getLocale()) // <- set locale
                ->isoFormat('LL'); // localized date
        }

        return $date;
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

     // Helper method to get display name with distinguishing info
    public function getDisplayNameAttribute(): string
    {
        $displayName = $this->name;

        // Add birth year if available to distinguish actors with same name
        if ($this->birth_date) {
            $displayName .= ' (' . $this->birth_date . ')';
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
}
