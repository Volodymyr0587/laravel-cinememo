<?php

namespace App\Livewire\ContentTypes;

use App\Models\ContentType;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $contentType = ContentType::where('user_id', auth()->id())->findOrFail($id);
        $contentType->delete();

        session()->flash('message', 'Content type deleted successfully.');
    }

    public function render()
    {
        $contentTypes = ContentType::where('user_id', auth()->id())
            ->where('name', 'like', '%' . $this->search . '%')
            ->withCount('contentItems')
            ->paginate(10);

        return view('livewire.content-types.index', compact('contentTypes'));
    }
}
