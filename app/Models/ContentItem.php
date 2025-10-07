<?php

namespace App\Models;

use App\Traits\HasImages;
use App\Helpers\DateHelper;
use Illuminate\Support\Str;
use App\Enums\ContentStatus;
use App\Observers\ContentItemObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([ContentItemObserver::class])]
class ContentItem extends Model
{
    use SoftDeletes, HasImages;

    protected $fillable = [
        'user_id',
        'content_type_id',
        'title',
        'description',
        'video_url',
        'video_id',
        'duration_in_seconds',
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

     /**
     * The people that belong to the ContentItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'content_item_person')
            ->using(ContentItemPerson::class)
            ->withPivot('profession_id')
            ->withTimestamps();
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

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        return $this->video_id
            ? "https://www.youtube.com/embed/{$this->video_id}"
            : null;
    }


    public function getFormattedReleaseDateAttribute(): string
    {
        return DateHelper::formatReleaseDate((string) $this->release_date);
    }

    /**
     * Accessor to get duration in a convenient format (H:i:s).
     * If 'duration_in_seconds' is null, returns '00:00:00'.
     */
    protected function formattedDuration(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $seconds = $attributes['duration_in_seconds'] ?? null;

                if ($seconds === null) {
                    return null;
                }

                // Standard HH:MM:SS
                $hhmmss = gmdate($seconds >= 3600 ? "H:i:s" : "i:s", $seconds);

                // Human-readable format
                $hours = intdiv($seconds, 3600);
                $minutes = intdiv($seconds % 3600, 60);
                $secs = $seconds % 60;

                $parts = [];
                if ($hours > 0) {
                    $parts[] = "{$hours}h";
                }
                if ($minutes > 0) {
                    $parts[] = "{$minutes}m";
                }
                if ($secs > 0) {
                    $parts[] = "{$secs}s";
                }

                $human = implode(' ', $parts) ?: '0s';

                return [
                    'hhmmss' => $hhmmss,
                    'human'  => $human,
                ];
            }
        );
    }


    public function getHoursAttribute(): ?int
    {
        return $this->duration_in_seconds ? intdiv($this->duration_in_seconds, 3600) : null;
    }

    public function getMinutesAttribute(): ?int
    {
        return $this->duration_in_seconds ? intdiv(($this->duration_in_seconds % 3600), 60) : null;
    }

    public function getSecondsAttribute(): ?int
    {
        return $this->duration_in_seconds ? $this->duration_in_seconds % 60 : null;
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
        'release_date' => 'date',
        'status' => ContentStatus::class,
        'is_public' => 'boolean',
    ];
}
