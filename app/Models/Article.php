<?php

namespace App\Models;

use App\Traits\HasImages;
use App\Traits\Taggable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Article extends Model
{
    use SoftDeletes, HasImages, Taggable;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'introduction',
        'main',
        'conclusion',
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

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function getReadingTimeAttribute(): int
    {
        $text = strip_tags("{$this->introduction} {$this->main} {$this->conclusion}");
        preg_match_all('/\p{L}+/u', $text, $matches);

        $wordCount = count($matches[0]);

        return max(1, ceil($wordCount / 200));
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

            if ($article->is_published && ! $article->published_at) {
                $article->published_at = now();
            }

            if (! $article->is_published) {
                $article->published_at = null;
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
