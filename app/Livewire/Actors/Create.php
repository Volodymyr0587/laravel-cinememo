<?php

namespace App\Livewire\Actors;

use App\Models\ContentItem;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $biography = '';
    public $birth_date = '';
    public $death_date = '';
    public $birth_place = '';
    public $main_image;
    public $additional_images = [];
    public $content_items = [];


    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'death_date' => ['nullable', 'date', 'after:birth_date'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'main_image' => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
        ];
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
        ]);

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

        // Зберігаємо жанри
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
