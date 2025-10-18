<?php

namespace App\Livewire\Admin\Genres;

use App\Models\Genre;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Genre $genre;
    public string $name = '';
    public string $description = '';


    public function mount(Genre $genre)
    {
        $this->authorize('view', $genre);

        $this->genre = $genre;
        $this->name = $genre->name;
        $this->description = $genre->description ?? '';
    }

    public function save()
    {
        $this->authorize('update', $this->genre);

        // Normalize BEFORE validation
        $this->name = trim(mb_strtolower($this->name));

        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('genres')->ignore($this->genre->id)
            ],
            'description' => ['nullable', 'string']
        ]);

        $this->genre->update($validated);

        session()->flash('message', __("genres/main.update_genre_message", ['name' => $this->genre->name]));

        return redirect()->route('admin.genres.index');
    }

    public function delete(int $genreId)
    {
        $genre = Genre::findOrFail($genreId);

        $this->authorize('delete', $genre);

        $genre->delete();

        session()->flash('message', __("genres/main.delete_genre_message", ['name' => $genre->name]));

        return redirect()->route('admin.genres.index');
    }

    public function render()
    {
        return view('livewire.admin.genres.edit');
    }
}
