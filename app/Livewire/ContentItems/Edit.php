<?php

namespace App\Livewire\ContentItems;

use App\Models\Genre;
use App\Models\Image;
use Livewire\Component;
use App\Models\ContentItem;
use App\Models\ContentType;
use App\Enums\ContentStatus;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public ContentItem $contentItem;
    public $content_type_id = '';
    public $title = '';
    public $description = '';
    public $image;
    public $status = '';
    public $is_public = '';
    public $existingImage = '';

    public $existingImages = [];
    public $newAdditionalImages = [];
    public $imagesToRemove = [];

    public $confirmingImageRemoval = false;
    public $imageIdToRemove = null;
    public $confirmingMainImageRemoval = false;
    public $genres = [];


    protected function rules(): array
    {
        return [
            'content_type_id' => 'required|exists:content_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB max
            'status' => ['required', Rule::in(ContentStatus::values())],
            'is_public' => ['boolean'],
            'newAdditionalImages.*' => 'nullable|image|max:2048',
            'imagesToRemove' => 'array',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ];
    }

    public function mount(ContentItem $contentItem)
    {
        // Ensure the content item belongs to the authenticated user
        $this->authorize('update', $contentItem);

        $this->contentItem = $contentItem;
        $this->content_type_id = $contentItem->content_type_id;
        $this->title = $contentItem->title;
        $this->description = $contentItem->description;
        $this->status = $contentItem->status->value;
        $this->is_public = $contentItem->is_public;
        $this->existingImage = $contentItem->image;

        $this->existingImages = $contentItem->additionalImages->toArray();

        $this->genres = $contentItem->genres()->pluck('genres.id')->toArray();
    }

    public function removeImage()
    {
        if ($this->existingImage) {
            Storage::disk('public')->delete($this->existingImage);
            $this->contentItem->update(['image' => null]);
            $this->existingImage = '';

            $this->confirmingMainImageRemoval = false;

            session()->flash('message', 'Main image removed successfully.');
        }
    }

    public function confirmMainImageRemoval()
    {
        $this->confirmingMainImageRemoval = true;
    }

    public function removeAdditionalImage($imageId)
    {
        $image = $this->contentItem->additionalImages()->findOrFail($imageId);

        // Delete file from storage
        Storage::disk('public')->delete($image->path);

        // Delete database record
        $image->delete();

        // Refresh contentItem relationship (optional if needed immediately in view)
        $this->contentItem->refresh();
    }

    public function confirmAdditionalImageRemoval($imageId)
    {
        $this->confirmingImageRemoval = true;
        $this->imageIdToRemove = $imageId;
    }

    public function deleteAdditionalImageConfirmed()
    {
        $image = $this->contentItem->additionalImages()->findOrFail($this->imageIdToRemove);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        $this->reset(['confirmingImageRemoval', 'imageIdToRemove']);

        // Refresh contentItem to update images list
        $this->contentItem->refresh();

        session()->flash('message', 'Image removed successfully.');
    }


    public function save()
    {
        $this->validate();

        $imagePath = $this->existingImage;

        if ($this->image) {
            // Delete old image if exists
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $imagePath = $this->image->store('content-images', 'public');
        }

        // delete images user selected to remove
        if (!empty($this->imagesToRemove)) {
            $images = Image::whereIn('id', $this->imagesToRemove)->get();

            foreach ($images as $image) {
                Storage::disk('public')->delete($image->path); // delete file from storage
                $image->delete(); // then delete DB record
            }
        }

        foreach ($this->newAdditionalImages as $file) {
            $path = $file->store('content-images', 'public');
            $this->contentItem->additionalImages()->create(['path' => $path]);
        }

        $this->contentItem->update([
            'content_type_id' => $this->content_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imagePath,
            'status' => $this->status,
            'is_public' => $this->is_public,
        ]);

        // оновлюємо жанри
        $this->contentItem->genres()->sync($this->genres);

        session()->flash('message', 'Content item updated successfully.');

        return redirect()->route('content-items.index');
    }

    public function render()
    {
        $contentTypes = ContentType::where('user_id', auth()->id())->get();
        $allGenres = Genre::orderBy('name')->get();

        return view('livewire.content-items.edit', compact('contentTypes', 'allGenres'));
    }
}
