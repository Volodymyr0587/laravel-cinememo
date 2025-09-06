<?php

namespace App\Livewire\Actors;

use Livewire\Component;
use App\Models\ContentItem;
use Livewire\WithFileUploads;
use App\Rules\ValidPartialDate;

class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $biography = '';
    public $birth_date = '';
    public $death_date = '';
    public $birth_place = '';
    public $death_place = '';
    public $main_image;
    public $additional_images = [];
    public $content_items = [];
    // Property to show existing actors with same name
    public $existing_actors = [];


    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => ['nullable', new ValidPartialDate(1800, now()->year)],
            'death_date' => ['nullable', new ValidPartialDate(1800, now()->year)],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'death_place' => ['nullable', 'string', 'max:255'],
            'main_image' => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
            'content_items' => 'array',
            'content_items.*' => 'exists:content_items,id',
        ];
    }

    // Check for existing actors with same name when name changes
    public function updatedName()
    {
        if (!empty($this->name)) {
            $this->existing_actors = auth()->user()->actors()
                ->where('name', 'LIKE', '%' . $this->name . '%')
                ->with('user')
                ->get()
                ->map(function ($actor) {
                    return [
                        'id' => $actor->id,
                        'name' => $actor->name,
                        'birth_date' => $actor->birth_date,
                        'birth_place' => $actor->birth_place,
                        'display_name' => $actor->display_name,
                    ];
                });
        } else {
            $this->existing_actors = [];
        }
    }

    public function save()
    {
        $this->validate();

        // Створюємо Actor
        $actor = auth()->user()->actors()->create([
            'name' => $this->name,
            'biography' => $this->biography,
            'birth_date' => $this->birth_date,
            'death_date' => $this->death_date,
            'birth_place' => $this->birth_place,
            'death_place' => $this->death_place,
        ]);

        // Extra check: death_date must be after birth_date
        if ($this->birth_date && $this->death_date) {
            if (strcmp($this->death_date, $this->birth_date) <= 0) {
                $this->addError('death_date', __('validation.custom.partial_date.after_birth'));
                return;
            }
        }

        // Додаємо головне зображення через нову поліморфну систему
        if ($this->main_image) {
            $mainImagePath = $this->main_image->store('actors', 'public');
            $actor->addMainImage($mainImagePath);
        }

        // Додаємо додаткові зображення через нову поліморфну систему
        foreach ($this->additional_images as $file) {
            $path = $file->store('actors', 'public');
            $actor->addAdditionalImage($path);
        }

        // Зберігаємо content items
        if (!empty($this->content_items)) {
            $actor->contentItems()->sync($this->content_items);
        }

        session()->flash('message', "Actor $actor->name has been added to your list of actors.");

        return redirect()->route('actors.index');
    }

    public function render()
    {
        $contentItems = ContentItem::where('user_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('livewire.actors.create', compact('contentItems'));
    }
}
