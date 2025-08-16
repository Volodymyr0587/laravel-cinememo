<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ContentItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'content_type_id',
        'title',
        'description',
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

    public function additionalImages(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
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
