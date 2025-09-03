<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Article extends Model
{
    use SoftDeletes, HasImages;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'body',
        'is_published',
    ];

    /**
     * Get the user that owns the Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            if ($article->isDirty('title')) {
                $slug = Str::slug($article->title);

                // Робимо slug унікальним
                $originalSlug = $slug;
                $counter = 1;
                while (static::where('slug', $slug)
                    ->where('id', '!=', $article->id)
                    ->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $article->slug = $slug;
            }
        });

        static::forceDeleted(function ($article) {
            $article->comments()->delete();
        });
    }

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
}
