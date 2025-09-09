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

    public function render()
    {
        return view('livewire.admin.genres.show');
    }
}
