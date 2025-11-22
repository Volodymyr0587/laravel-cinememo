<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentItemPerson extends Pivot
{
     // explicitly specify the table if its name does not follow the convention
    protected $table = 'content_item_person';
    /**
     * Get the profession that owns the ContentItemPerson
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class);
    }
}
