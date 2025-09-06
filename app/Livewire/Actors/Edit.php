<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Livewire\Component;
use App\Models\ContentItem;
use Livewire\WithFileUploads;
use App\Rules\ValidPartialDate;

class Edit extends Component
{
    use WithFileUploads;

    public Actor $actor;

    public $name = '';
    public $biography = '';
    public $birth_date = '';
    public $death_date = '';
    public $birth_place = '';
    public $death_place = '';

    public $new_main_image; // нове головне фото
    public $newAdditionalImages = [];

    public $content_items = [];

    public $confirmingMainImageRemoval = false;
    public $confirmingImageRemoval = false;
    public $imageIdToRemove = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => ['nullable', new ValidPartialDate(1800, now()->year)],
            'death_date' => ['nullable', new ValidPartialDate(1800, now()->year)],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'death_place' => ['nullable', 'string', 'max:255'],
            'new_main_image' => 'nullable|image|max:2048',
            'newAdditionalImages.*' => 'nullable|image|max:2048',
            'content_items' => 'array',
            'content_items.*' => 'exists:content_items,id',
        ];
    }

    public function mount(Actor $actor)
    {
        $this->authorize('update', $actor);

        $this->actor = $actor;
        $this->name = $actor->name;
        $this->biography = $actor->biography;
        $this->birth_date = $actor->birth_date;
        $this->death_date = $actor->death_date;
        $this->birth_place = $actor->birth_place;
        $this->death_place = $actor->death_place;
        $this->content_items = $actor->contentItems()->pluck('content_items.id')->toArray();
    }

    public function save()
    {
        $this->validate();

        // Extra check: death_date must be after birth_date
        if ($this->birth_date && $this->death_date) {
            if (strcmp($this->death_date, $this->birth_date) <= 0) {
                $this->addError('death_date', __('validation.custom.partial_date.after_birth'));
                return;
            }
        }

        // додаємо нове головне фото
        if ($this->new_main_image) {
            $path = $this->new_main_image->store('actors', 'public');
            $this->actor->addMainImage($path);
        }

        // додаємо нові додаткові фото
        foreach ($this->newAdditionalImages as $file) {
            $path = $file->store('actors', 'public');
            $this->actor->addAdditionalImage($path);
        }

        // оновлюємо основні поля
        $this->actor->update([
            'name' => $this->name,
            'biography' => $this->biography,
            'birth_date' => $this->birth_date,
            'death_date' => $this->death_date,
            'birth_place' => $this->birth_place,
            'death_place' => $this->death_place,
        ]);

        // оновлюємо пов’язані контент-айтеми
        $this->actor->contentItems()->sync($this->content_items);

        session()->flash('message', 'Actor updated successfully.');

        return redirect()->route('actors.index');
    }

    public function confirmMainImageRemoval()
    {
        $this->confirmingMainImageRemoval = true;
    }

    public function removeMainImage()
    {
        $this->actor->removeMainImage();
        $this->confirmingMainImageRemoval = false;
        $this->actor->refresh();

        session()->flash('message', 'Main image removed successfully.');
    }

    public function confirmAdditionalImageRemoval($imageId)
    {
        $this->confirmingImageRemoval = true;
        $this->imageIdToRemove = $imageId;
    }

    public function deleteAdditionalImageConfirmed()
    {
        $this->actor->removeAdditionalImage($this->imageIdToRemove);

        $this->reset(['confirmingImageRemoval', 'imageIdToRemove']);
        $this->actor->refresh();

        session()->flash('message', 'Additional image removed successfully.');
    }

    public function render()
    {
        $contentItems = ContentItem::where('user_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('livewire.actors.edit', compact('contentItems'));
    }
}
