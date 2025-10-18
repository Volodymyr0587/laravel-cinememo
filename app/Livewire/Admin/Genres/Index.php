<?php

namespace App\Livewire\Admin\Genres;

use App\Models\Genre;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function clearFilters(): void
    {
        $this->reset(['search']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
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
        $query = Genre::orderBy('name');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $allGenres = $query->paginate(10)->withQueryString();

        return view('livewire.admin.genres.index', compact('allGenres'));
    }
}
