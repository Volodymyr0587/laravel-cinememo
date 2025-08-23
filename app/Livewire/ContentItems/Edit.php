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

class Edit extends Component
{
    use WithFileUploads;

    public ContentItem $contentItem;
    public $content_type_id = '';
    public $title = '';
    public $description = '';
    public $release_date = '';
    public $new_main_image; // Нове головне зображення
    public $status = '';
    public $is_public = '';

    public $newAdditionalImages = [];
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
            'release_date' => ['nullable', 'string', new \App\Rules\ValidReleaseDate()],
            'new_main_image' => 'nullable|image|max:2048',
            'status' => ['required', Rule::in(ContentStatus::values())],
            'is_public' => ['boolean'],
            'newAdditionalImages.*' => 'nullable|image|max:2048',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ];
    }

    public function mount(ContentItem $contentItem)
    {
        $this->authorize('update', $contentItem);

        $this->contentItem = $contentItem;
        $this->content_type_id = $contentItem->content_type_id;
        $this->title = $contentItem->title;
        $this->description = $contentItem->description;
        $this->release_date = $contentItem->release_date;
        $this->status = $contentItem->status->value;
        $this->is_public = $contentItem->is_public;
        $this->genres = $contentItem->genres()->pluck('genres.id')->toArray();
    }

    public function removeMainImage()
    {
        $this->contentItem->removeMainImage();
        $this->confirmingMainImageRemoval = false;

        // Оновлюємо модель для відображення змін
        $this->contentItem->refresh();

        session()->flash('message', 'Main image removed successfully.');
    }

    public function confirmMainImageRemoval()
    {
        $this->confirmingMainImageRemoval = true;
    }

    public function confirmAdditionalImageRemoval($imageId)
    {
        $this->confirmingImageRemoval = true;
        $this->imageIdToRemove = $imageId;
    }

    public function deleteAdditionalImageConfirmed()
    {
        $this->contentItem->removeAdditionalImage($this->imageIdToRemove);

        $this->reset(['confirmingImageRemoval', 'imageIdToRemove']);

        // Оновлюємо модель для відображення змін
        $this->contentItem->refresh();

        session()->flash('message', 'Additional image removed successfully.');
    }

    public function save()
    {
        $this->validate();

        // Додаємо нове головне зображення, якщо завантажено
        if ($this->new_main_image) {
            $mainImagePath = $this->new_main_image->store('content-images', 'public');
            $this->contentItem->addMainImage($mainImagePath);
        }

        // Додаємо нові додаткові зображення
        foreach ($this->newAdditionalImages as $file) {
            $path = $file->store('content-images', 'public');
            $this->contentItem->addAdditionalImage($path);
        }

        // Оновлюємо основну інформацію
        $this->contentItem->update([
            'content_type_id' => $this->content_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'status' => $this->status,
            'is_public' => $this->is_public,
        ]);

        // Оновлюємо жанри
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
