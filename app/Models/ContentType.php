<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentType extends Model
{
    protected $fillable = ['user_id', 'name', 'color'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contentItems(): HasMany
    {
        return $this->hasMany(ContentItem::class);
    }

    protected static function booted()
    {
        static::deleting(function ($contentType) {
            if ($contentType->contentItems()->exists()) {
                throw new \Exception('Cannot delete ContentType with related ContentItems.');
            }
        });
    }
}
