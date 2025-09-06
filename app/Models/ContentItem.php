<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Support\Str;
use App\Enums\ContentStatus;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ContentItem extends Model
{
    use SoftDeletes, HasImages;

    protected $fillable = [
        'user_id',
        'content_type_id',
        'title',
        'description',
        'release_date',
        'image',
        'status',
        'slug',
        'is_public',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contentType(): BelongsTo
    {
        return $this->belongsTo(ContentType::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'content_item_genre');
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_content_item');
    }


    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->mainImage) {
            return Storage::url($this->mainImage->path);
        }
    }

    public function getFormattedReleaseDateAttribute(): string
    {
        $date = $this->release_date;

        if (preg_match('/^\d{4}$/', $date)) {
            return $date;
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

        static::saving(function ($contentItem) {
            if ($contentItem->isDirty('title')) {
                $slug = Str::slug($contentItem->title);

                // Робимо slug унікальним
                $originalSlug = $slug;
                $counter = 1;
                while (static::where('slug', $slug)
                    ->where('id', '!=', $contentItem->id)
                    ->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $contentItem->slug = $slug;
            }
        });

        static::forceDeleted(function ($contentItem) {
            $contentItem->comments()->delete();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'status' => ContentStatus::class,
        'is_public' => 'boolean',
    ];
}
