<?php

namespace App\Livewire\ContentItems;

use App\Models\Genre;
use Livewire\Component;
use App\Rules\YoutubeUrl;
use App\Models\ContentItem;
use App\Models\ContentType;
use App\Enums\ContentStatus;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class Edit extends Component
{
    use WithFileUploads;

    public ContentItem $contentItem;

    #[Validate('required')]
    public $content_type_id = '';
    public $title = '';
    public $description = '';
    public ?string $video_url = null;
    public ?int $hours = null;
    public ?int $minutes = null;
    public ?int $seconds = null;
    public $release_date = '';
    public $new_main_image; // Нове головне зображення
    public $status = '';
    public $is_public = '';

    public $newAdditionalImages = [];
    public $confirmingImageRemoval = false;
    public $imageIdToRemove = null;
    public $confirmingMainImageRemoval = false;
    public $genres = [];
    public $selectedPeople = [];

    protected function rules(): array
    {
        return [
            'content_type_id' => 'required|exists:content_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => ['nullable', 'string', new YoutubeUrl],
            'hours' => 'nullable|integer|min:0',
            'minutes' => 'nullable|integer|min:0|max:59',
            'seconds' => 'nullable|integer|min:0|max:59',
            'release_date' => ['nullable', 'date'],
            'new_main_image' => 'nullable|image|max:2048',
            'status' => ['required', Rule::in(ContentStatus::values())],
            'is_public' => ['boolean'],
            'newAdditionalImages.*' => 'nullable|image|max:2048',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
            'selectedPeople' => 'array',
        ];
    }

    protected function messages(): array
    {
        return [
            'content_type_id.required' => __('content_items/edit.select_category'),
        ];
    }

    public function mount(ContentItem $contentItem)
    {
        $this->authorize('update', $contentItem);

        $this->contentItem = $contentItem;
        $this->content_type_id = $contentItem->content_type_id;
        $this->title = $contentItem->title;
        $this->description = $contentItem->description;
        $this->video_url = $contentItem->video_url;
        $this->hours = $contentItem->hours;
        $this->minutes = $contentItem->minutes;
        $this->seconds = $contentItem->seconds;
        $this->release_date = $contentItem->release_date?->format('Y-m-d');
        $this->status = $contentItem->status->value;
        $this->is_public = $contentItem->is_public;
        $this->genres = $contentItem->genres()->pluck('genres.id')->toArray();
        // Load existing people relationships and convert to selectedPeople format
        $this->loadExistingPeople();
    }

    private function loadExistingPeople()
    {
        $this->selectedPeople = [];

        // Get all people with their professions for this content item
        $existingPeople = $this->contentItem->people()->get();

        foreach ($existingPeople as $person) {
            $key = $person->id . '_' . $person->pivot->profession_id;
            $this->selectedPeople[$key] = true;
        }
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

        $videoId = $this->video_url
            ? YoutubeUrl::extractId($this->video_url)
            : null;

        $durationInSeconds = ($this->hours ?? 0) * 3600
                   + ($this->minutes ?? 0) * 60
                   + ($this->seconds ?? 0);

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
            'video_url' => $this->video_url,
            'video_id'  => $videoId,
            'duration_in_seconds' => $durationInSeconds ?: null,
            'release_date' => $this->release_date ? \Carbon\Carbon::parse($this->release_date) : null,
            'status' => $this->status,
            'is_public' => $this->is_public,
        ]);

        // Оновлюємо жанри
        $this->contentItem->genres()->sync($this->genres);

        $this->updatePeopleRelationships();

        session()->flash('message', __('content_items/edit.content_updated_message', ['title' => $this->contentItem->title]));

        return redirect()->route('content-items.show', $this->contentItem);
    }

    private function updatePeopleRelationships()
    {
        // First, detach all existing people relationships
        $this->contentItem->people()->detach();

        // Then attach the selected people with their professions
        if (!empty($this->selectedPeople)) {
            foreach ($this->selectedPeople as $key => $isSelected) {
                if ($isSelected) {
                    [$personId, $professionId] = explode('_', $key);

                    // Check if this person-profession combination already exists to avoid duplicates
                    $exists = $this->contentItem->people()
                        ->wherePivot('profession_id', $professionId)
                        ->where('person_id', $personId)
                        ->exists();

                    if (!$exists) {
                        $this->contentItem->people()->attach($personId, ['profession_id' => $professionId]);
                    }
                }
            }
        }
    }

    public function render()
    {
        $contentTypes = ContentType::where('user_id', auth()->id())->get();
        $allGenres = Genre::orderBy('name')->get(['id', 'name']);;
        $professions = \App\Models\Profession::with(['people' => function ($q) {
            $q->where('user_id', auth()->id());
        }])->get();

        return view('livewire.content-items.edit', compact('contentTypes', 'allGenres', 'professions'));
    }
}
