<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Taggable
{
    /**
     * Define polymorphic relation
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }

    /**
     * Sync tags for this model.
     *
     * @param  array|string|Collection  $tags
     * @return array [existingTags, newTags]
     */
    public function syncTags(array|string|Collection $tags): array
    {
        $tagNames = collect(is_string($tags) ? explode(',', $tags) : $tags)
            ->map(fn($tag) => trim(strtolower($tag)))
            ->filter()
            ->unique();

        $existingTags = Tag::whereIn('name', $tagNames)->pluck('name')->toArray();
        $newTags = $tagNames->diff($existingTags);

        foreach ($newTags as $name) {
            Tag::create(['name' => $name]);
        }

        $tagIds = Tag::whereIn('name', $tagNames)->pluck('id');
        $this->tags()->sync($tagIds);

        return [$existingTags, $newTags->toArray()];

    }

    protected static function bootTaggable()
    {
        static::forceDeleted(function ($model) {
            $model->tags()->detach();

            // delete tags that no longer exist in pivot
            Tag::whereNotIn('id', function ($query) {
                $query->select('tag_id')->from('taggables');
            })->delete();
        });
    }
}
