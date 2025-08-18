<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The contentItems that belong to the Genre
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contentItems(): BelongsToMany
    {
        return $this->belongsToMany(ContentItem::class, 'content_item_genre');
    }
}
