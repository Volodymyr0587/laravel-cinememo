<?php

namespace App\Livewire\Admin\Genres;

use App\Models\Genre;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public string $name = '';
    public string $description = '';

    public function save()
    {
        $this->authorize('create', Genre::class);

        // Normalize BEFORE validation
        $this->name = trim(mb_strtolower($this->name));

        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('genres'),
            ],
            'description' => ['nullable', 'string']
        ]);

        $genre = Genre::create($validated);

        session()->flash('message', __("genres/main.create_genre_message", ['name' => $genre->name]));

        return redirect()->route('admin.genres.index');
    }
    public function render()
    {
        return view('livewire.admin.genres.create');
    }
}
