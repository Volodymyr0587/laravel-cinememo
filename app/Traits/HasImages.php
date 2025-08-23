<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;

trait HasImages
{
    /**
     * All model images
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Main model image
     */
    public function mainImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'main');
    }

    /**
     * Additional model images
     */
    public function additionalImages(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', 'additional');
    }

    /**
     * Get the URL of the main image
     */
    public function getMainImageUrlAttribute(): ?string
    {
        $mainImage = $this->mainImage;
        return $mainImage ? Storage::url($mainImage->path) : null;
    }

    /**
     * Get URLs of all additional images
     */
    public function getAdditionalImageUrlsAttribute(): array
    {
        return $this->additionalImages->map(function ($image) {
            return Storage::url($image->path);
        })->toArray();
    }

    /**
     * Add main image
     */
    public function addMainImage(string $path): Image
    {
        // Видаляємо попереднє головне зображення, якщо є
        $this->removeMainImage();

        return $this->images()->create([
            'path' => $path,
            'type' => 'main'
        ]);
    }

    /**
     * Add an additional image
     */
    public function addAdditionalImage(string $path): Image
    {
        return $this->images()->create([
            'path' => $path,
            'type' => 'additional'
        ]);
    }

    /**
     * Delete main image
     */
    public function removeMainImage(): bool
    {
        $mainImage = $this->mainImage;
        if ($mainImage) {
            Storage::disk('public')->delete($mainImage->path);
            return $mainImage->delete();
        }
        return false;
    }

    /**
     * Delete additional image by ID
     */
    public function removeAdditionalImage(int $imageId): bool
    {
        $image = $this->additionalImages()->findOrFail($imageId);
        Storage::disk('public')->delete($image->path);
        return $image->delete();
    }

    /**
     * Delete all images
     */
    public function removeAllImages(): void
    {
        foreach ($this->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }
}
