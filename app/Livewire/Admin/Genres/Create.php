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

        return redirect()->route('admin.genres.index')
                        ->with('success',"Genre {$genre->name} created successfully");
    }
    public function render()
    {
        return view('livewire.admin.genres.create');
    }
}
