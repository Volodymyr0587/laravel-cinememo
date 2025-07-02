<?php

namespace App\Models;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentItem extends Model
{
    protected $fillable = [
        'content_type_id',
        'title',
        'description',
        'image',
        'status'
    ];

    public function contentType(): BelongsTo
    {
        return $this->belongsTo(ContentType::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    protected $casts = [
        'status' => ContentStatus::class,
    ];
}
