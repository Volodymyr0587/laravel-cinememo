<?php

namespace App\Livewire\People;

use App\Models\Person;
use Livewire\Component;
use App\Models\Profession;
use App\Models\ContentItem;
use Livewire\WithFileUploads;


class Edit extends Component
{
    use WithFileUploads;

    public Person $person;

    public $name = '';
    public $biography = '';
    public $birth_date;
    public $death_date;
    public $birth_place = '';
    public $death_place = '';

    public $new_main_image; // нове головне фото
    public $newAdditionalImages = [];

    public $content_items = [];
    public $professions = [];

    public $confirmingMainImageRemoval = false;
    public $confirmingImageRemoval = false;
    public $imageIdToRemove = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => ['nullable', 'date', 'before:today'],
            'death_date' => ['nullable', 'date', 'after:birth_date'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'death_place' => ['nullable', 'string', 'max:255'],
            'new_main_image' => 'nullable|image|max:2048',
            'newAdditionalImages.*' => 'nullable|image|max:2048',
            'content_items' => 'array',
            'content_items.*' => 'exists:content_items,id',
            'professions' => 'array',
            'professions.*' => 'exists:professions,id',
        ];
    }

    public function mount(Person $person)
    {
        $this->authorize('update', $person);

        $this->person = $person;
        $this->name = $person->name;
        $this->biography = $person->biography;
        $this->birth_date = $person->birth_date?->format('Y-m-d');
        $this->death_date = $person->death_date?->format('Y-m-d');
        $this->birth_place = $person->birth_place;
        $this->death_place = $person->death_place;
        $this->content_items = $person->contentItems()->pluck('content_items.id')->toArray();
        $this->professions = $person->professions()->pluck('professions.id')->toArray();
    }

    public function save()
    {
        $this->validate();

        // Extra check: death_date must be after birth_date
        // if ($this->birth_date && $this->death_date) {
        //     if (strcmp($this->death_date, $this->birth_date) <= 0) {
        //         $this->addError('death_date', __('validation.custom.partial_date.after_birth'));
        //         return;
        //     }
        // }

        // додаємо нове головне фото
        if ($this->new_main_image) {
            $path = $this->new_main_image->store('people', 'public');
            $this->person->addMainImage($path);
        }

        // додаємо нові додаткові фото
        foreach ($this->newAdditionalImages as $file) {
            $path = $file->store('people', 'public');
            $this->person->addAdditionalImage($path);
        }

        // оновлюємо основні поля
        $this->person->update([
            'name' => $this->name,
            'biography' => $this->biography,
            'birth_date' => $this->birth_date ? \Carbon\Carbon::parse($this->birth_date) : null,
            'death_date' => $this->death_date ? \Carbon\Carbon::parse($this->death_date) : null,
            'birth_place' => $this->birth_place,
            'death_place' => $this->death_place,
        ]);

        // оновлюємо пов’язані контент-айтеми
        $this->person->contentItems()->sync($this->content_items);

        $this->person->professions()->sync($this->professions);


        session()->flash('message', 'Person updated successfully.');

        return redirect()->route('people.index');
    }

    public function confirmMainImageRemoval()
    {
        $this->confirmingMainImageRemoval = true;
    }

    public function removeMainImage()
    {
        $this->person->removeMainImage();
        $this->confirmingMainImageRemoval = false;
        $this->person->refresh();

        session()->flash('message', 'Main image removed successfully.');
    }

    public function confirmAdditionalImageRemoval($imageId)
    {
        $this->confirmingImageRemoval = true;
        $this->imageIdToRemove = $imageId;
    }

    public function deleteAdditionalImageConfirmed()
    {
        $this->person->removeAdditionalImage($this->imageIdToRemove);

        $this->reset(['confirmingImageRemoval', 'imageIdToRemove']);
        $this->person->refresh();

        session()->flash('message', 'Additional image removed successfully.');
    }

    public function render()
    {
        $contentItems = ContentItem::where('user_id', auth()->id())
            ->orderBy('title')
            ->get();

        $allProfessions = Profession::orderBy('name')->get();

        return view('livewire.people.edit', compact('contentItems', 'allProfessions'));
    }
}
