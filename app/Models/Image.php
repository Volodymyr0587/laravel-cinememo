<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'path',
        'type'
    ];

    /**
     * Image can belongs to different models
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope for get main image
     */
    public function scopeMain($query)
    {
        return $query->where('type', 'main');
    }

    /**
     * Scope for get additional images
     */
    public function scopeAdditional($query)
    {
        return $query->where('type', 'additional');
    }
}
