<?php

namespace App\Livewire\ContentItems;

use App\Models\Genre;
use Livewire\Component;
use App\Rules\YoutubeUrl;
use App\Models\ContentType;
use App\Enums\ContentStatus;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class Create extends Component
{
    use WithFileUploads;

    #[Validate('required', message: 'Please select a category. If there are no categories, first create one in the Categories section.')]
    public $content_type_id = '';
    public $title = '';
    public $description = '';
    public ?string $video_url = null;
    public ?int $hours = null;
    public ?int $minutes = null;
    public ?int $seconds = null;
    public $release_date = '';
    public $main_image; // Змінюємо назву для ясності
    public $status = 'willwatch';
    public $is_public = false;
    public $additional_images = [];
    public $genres = [];
    public $selectedPeople = [];


    public function mount()
    {
        $this->genres = [];
        $this->selectedPeople = [];
    }


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
            'main_image' => 'nullable|image|max:2048',
            'status' => ['required', Rule::in(ContentStatus::values())],
            'is_public' => ['boolean'],
            'additional_images.*' => 'nullable|image|max:2048',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
            'selectedPeople' => 'array',
        ];
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

        // Створюємо ContentItem
        $contentItem = auth()->user()->contentItems()->create([
            'content_type_id' => $this->content_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'video_url' => $this->video_url,
            'video_id'  => $videoId,
            'duration_in_seconds' => $durationInSeconds ?: null,
            'release_date' => $this->release_date ? \Carbon\Carbon::parse($this->release_date) : null,
            'status' => $this->status,
            'is_public' => $this->is_public,
            // Тимчасово залишаємо image поле порожнім для нової системи
        ]);

        // Додаємо головне зображення через нову поліморфну систему
        if ($this->main_image) {
            $mainImagePath = $this->main_image->store('content-images', 'public');
            $contentItem->addMainImage($mainImagePath);
        }

        // Додаємо додаткові зображення через нову поліморфну систему
        foreach ($this->additional_images as $file) {
            $path = $file->store('content-images', 'public');
            $contentItem->addAdditionalImage($path);
        }

        // Зберігаємо жанри
        if (!empty($this->genres)) {
            $contentItem->genres()->sync($this->genres);
        }

        if (!empty($this->selectedPeople)) {
            foreach ($this->selectedPeople as $key => $isSelected) {
                if ($isSelected) {
                    [$personId, $professionId] = explode('_', $key);

                    // Check if this person-profession combination already exists
                    $exists = $contentItem->people()
                        ->wherePivot('profession_id', $professionId)
                        ->where('person_id', $personId)
                        ->exists();

                    if (!$exists) {
                        $contentItem->people()->attach($personId, ['profession_id' => $professionId]);
                    }
                }
            }
        }

        session()->flash('message', 'Content item created successfully.');

        return redirect()->route('content-items.index');
    }

    public function render()
    {
        $contentTypes = ContentType::where('user_id', auth()->id())->get();
        $allGenres = Genre::orderBy('name')->get(['id', 'name']);;
        $professions = \App\Models\Profession::with(['people' => function ($q) {
            $q->where('user_id', auth()->id());
        }])->get();

        return view('livewire.content-items.create', compact('contentTypes', 'allGenres', 'professions'));
    }
}
