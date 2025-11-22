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

    #[Validate('required')]
    public $content_type_id = '';
    public $title = '';
    public $original_title = null;
    public $description = null;
    public ?string $video_url = null;
    public ?int $hours = null;
    public ?int $minutes = null;
    public ?int $seconds = null;
    public $release_date = null;
    public $number_of_seasons = null;
    public $season_number = null;
    public $number_of_series_of_season = null;
    public $country_of_origin = null;
    public $language = null;
    public $main_image;
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
            'original_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'video_url' => ['nullable', 'string', new YoutubeUrl],
            'hours' => 'nullable|integer|min:0',
            'minutes' => 'nullable|integer|min:0|max:59',
            'seconds' => 'nullable|integer|min:0|max:59',
            'release_date' => 'nullable|date',
            'number_of_seasons' => 'nullable|integer|min:1|max:100',
            'season_number' => 'nullable|integer|min:1|max:100',
            'number_of_series_of_season' => 'nullable|integer|min:1|max:15000',
            'country_of_origin' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:60',
            'main_image' => 'nullable|image|max:2048',
            'status' => ['required', Rule::in(ContentStatus::values())],
            'is_public' => 'boolean',
            'additional_images.*' => 'nullable|image|max:2048',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
            'selectedPeople' => 'array',
        ];
    }

    protected function messages(): array
    {
        return [
            'content_type_id.required' => __('content_items/create.select_category'),
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

        // Create ContentItem
        $contentItem = auth()->user()->contentItems()->create([
            'content_type_id' => $this->content_type_id,
            'title' => $this->title,
            'original_title' => $this->original_title,
            'description' => $this->description,
            'video_url' => $this->video_url,
            'video_id'  => $videoId,
            'duration_in_seconds' => $durationInSeconds ?: null,
            'release_date' => $this->release_date ? \Carbon\Carbon::parse($this->release_date) : null,
            'number_of_seasons' => $this->number_of_seasons,
            'season_number' => $this->season_number,
            'number_of_series_of_season' => $this->number_of_series_of_season,
            'country_of_origin' => $this->country_of_origin,
            'language' => $this->language,
            'status' => $this->status,
            'is_public' => $this->is_public,
        ]);

        // Adding the main image via a polymorphic system
        if ($this->main_image) {
            $mainImagePath = $this->main_image->store('content-images', 'public');
            $contentItem->addMainImage($mainImagePath);
        }

        // Adding additional images through a polymorphic system
        foreach ($this->additional_images as $file) {
            $path = $file->store('content-images', 'public');
            $contentItem->addAdditionalImage($path);
        }

        // Sync genres
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

        session()->flash('message', __('content_items/create.content_created_message', ['title' => $contentItem->title]));

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
