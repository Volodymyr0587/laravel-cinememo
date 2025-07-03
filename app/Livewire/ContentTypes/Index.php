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
        try {
            $contentType = ContentType::where('user_id', auth()->id())->findOrFail($id);
            $contentType->delete();

            session()->flash('message', 'Content type deleted successfully.');
        } catch (\Exception $e) {
             session()->flash('message', $e->getMessage());
        }

    }

    public function render()
    {
        $contentTypes = ContentType::where('user_id', auth()->id())
            ->where('name', 'like', '%' . $this->search . '%')
            ->withCount('contentItems')
            ->paginate(10)->withQueryString();

        return view('livewire.content-types.index', compact('contentTypes'));
    }
}
