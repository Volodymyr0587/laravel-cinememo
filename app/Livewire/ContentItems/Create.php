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
    public $image;
    public $status = 'willwatch';
    public $is_public = false;
    public $additional_images = [];
    public $genres = [];

    protected function rules(): array
    {
        return [
            'content_type_id' => 'required|exists:content_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => ['nullable', 'string', new \App\Rules\ValidReleaseDate()],
            'image' => 'nullable|image|max:2048', // 2MB max
            'status' => ['required', Rule::in(ContentStatus::values())],
            'is_public' => ['boolean'],
            'additional_images.*' => 'nullable|image|max:2048',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ];
    }

    public function save()
    {
        $this->validate();

        $imagePath = $this->image ? $this->image->store('content-images', 'public') : null;

        $contentItem = auth()->user()->contentItems()->create([
            'content_type_id' => $this->content_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'image' => $imagePath,
            'status' => $this->status,
            'is_public' => $this->is_public,
        ]);

        foreach ($this->additional_images as $file) {
            $path = $file->store('content-images', 'public');
            $contentItem->additionalImages()->create(['path' => $path]);
        }

        // Зберігаємо жанри
        if (!empty($this->genres)) {
            $contentItem->genres()->sync($this->genres);
        }

        session()->flash('message', 'Content item created successfully.');

        return redirect()->route('content-items.index');
    }

    public function render()
    {
        $contentTypes = ContentType::where('user_id', auth()->id())->get();
        $allGenres = Genre::orderBy('name')->get();

        return view('livewire.content-items.create', compact('contentTypes', 'allGenres'));
    }
}
