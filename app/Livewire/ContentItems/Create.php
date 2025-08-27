<?php

namespace App\Livewire\ContentItems;

use App\Models\Genre;
use Livewire\Component;
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
    public $release_date = '';
    public $main_image; // Змінюємо назву для ясності
    public $status = 'willwatch';
    public $is_public = false;
    public $additional_images = [];
    public $genres = [];
    public $actors = [];

    public function mount()
    {
        $this->genres = [];
        $this->actors = [];
    }


    protected function rules(): array
    {
        return [
            'content_type_id' => 'required|exists:content_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => ['nullable', 'string', new \App\Rules\ValidReleaseDate()],
            'main_image' => 'nullable|image|max:2048',
            'status' => ['required', Rule::in(ContentStatus::values())],
            'is_public' => ['boolean'],
            'additional_images.*' => 'nullable|image|max:2048',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
            'actors' => 'array',
            'actors.*' => 'exists:actors,id',
        ];
    }

    public function save()
    {
        $this->validate();

        // Створюємо ContentItem
        $contentItem = auth()->user()->contentItems()->create([
            'content_type_id' => $this->content_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'release_date' => $this->release_date,
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

        // Зберігаємо акторів
        if (!empty($this->actors)) {
            $contentItem->actors()->sync($this->actors);
        }

        session()->flash('message', 'Content item created successfully.');

        return redirect()->route('content-items.index');
    }

    public function render()
    {
        $contentTypes = ContentType::where('user_id', auth()->id())->get();
        $allGenres = Genre::orderBy('name')->get(['id', 'name']);;
        $allUserActors = auth()->user()->actors()->with('mainImage')->orderBy('name')->get();

        return view('livewire.content-items.create', compact('contentTypes', 'allGenres', 'allUserActors'));
    }
}
