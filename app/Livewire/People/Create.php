<?php

namespace App\Livewire\People;

use Livewire\Component;
use App\Models\Profession;
use App\Models\ContentItem;
use Livewire\WithFileUploads;


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
    // Property to show existing people with same name
    public $existing_people = [];

    public $professions = [];


    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => ['nullable', 'date', 'before:today'],
            'death_date' => ['nullable', 'date', 'after:birth_date'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'death_place' => ['nullable', 'string', 'max:255'],
            'main_image' => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
            'content_items' => 'array',
            'content_items.*' => 'exists:content_items,id',
            'professions' => 'array',
            'professions.*' => 'exists:professions,id',
        ];
    }

    // Check for existing people with same name when name changes
    public function updatedName()
    {
        if (!empty($this->name)) {
            $this->existing_people = auth()->user()->people()
                ->where('name', 'LIKE', '%' . $this->name . '%')
                ->with('user')
                ->get()
                ->map(function ($person) {
                    return [
                        'id' => $person->id,
                        'name' => $person->name,
                        'birth_date' => $person->birth_date?->format('M-d-Y'),
                        'birth_place' => $person->birth_place,
                        'display_name' => $person->display_name,
                    ];
                });
        } else {
            $this->existing_people = [];
        }
    }

    public function save()
    {
        $this->validate();

        // Створюємо Person
        $person = auth()->user()->people()->create([
            'name' => $this->name,
            'biography' => $this->biography,
            'birth_date' => $this->birth_date ? \Carbon\Carbon::parse($this->birth_date) : null,
            'death_date' => $this->death_date ? \Carbon\Carbon::parse($this->death_date) : null,
            'birth_place' => $this->birth_place,
            'death_place' => $this->death_place,
        ]);

        // Додаємо головне зображення через нову поліморфну систему
        if ($this->main_image) {
            $mainImagePath = $this->main_image->store('people', 'public');
            $person->addMainImage($mainImagePath);
        }

        // Додаємо додаткові зображення через нову поліморфну систему
        foreach ($this->additional_images as $file) {
            $path = $file->store('people', 'public');
            $person->addAdditionalImage($path);
        }

        // Зберігаємо content items
        if (!empty($this->content_items)) {
            $person->contentItems()->sync($this->content_items);
        }

        // Зберігаємо content items
        if (!empty($this->professions)) {
            $person->professions()->sync($this->professions);
        }

        session()->flash('message', "Person $person->name has been added to your list of people.");

        return redirect()->route('people.index');
    }

    public function render()
    {
        $contentItems = ContentItem::where('user_id', auth()->id())
            ->orderBy('title')
            ->get();

        $allProfessions = Profession::orderBy('name')->get();

        return view('livewire.people.create', compact('contentItems', 'allProfessions'));
    }
}
