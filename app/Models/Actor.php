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
        'birth_place'
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
            return $date;
        }

        if (preg_match('/^\d{4}-\d{2}$/', $date)) {
            return \Carbon\Carbon::createFromFormat('Y-m', $date)->format('Y-M');
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('Y-M-d');
        }

        return $date;
    }

    public function getFormattedDeathDateAttribute(): string
    {
        $date = $this->death_date;

        if (preg_match('/^\d{4}$/', $date)) {
            return $date;
        }

        if (preg_match('/^\d{4}-\d{2}$/', $date)) {
            return \Carbon\Carbon::createFromFormat('Y-m', $date)->format('Y-M');
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('Y-M-d');
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

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
