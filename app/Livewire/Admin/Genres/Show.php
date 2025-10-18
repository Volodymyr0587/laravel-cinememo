<?php

namespace App\Livewire\Admin\Genres;

use App\Models\Genre;
use Livewire\Component;

class Show extends Component
{
    public Genre $genre;

    public function mount(Genre $genre)
    {
        $this->authorize('view', $genre);

        $this->genre = $genre;
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
        return view('livewire.admin.genres.show');
    }
}
