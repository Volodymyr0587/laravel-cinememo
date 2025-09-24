<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentItemPerson extends Pivot
{
     // Явно вказуємо таблицю, якщо її назва не відповідає конвенції
    protected $table = 'content_item_person';

    // Визначаємо зв'язок з моделлю Profession
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
