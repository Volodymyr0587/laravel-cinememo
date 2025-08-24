<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $contentItemFilter = '';

    public function clearFilters(): void
    {
        $this->search = '';
        $this->contentItemFilter = '';
    }


    public function delete($id)
    {
        try {
            $actor = Actor::where('user_id', auth()->id())->findOrFail($id);
            $actor->delete();

            session()->flash('message', "Actor $actor->name deleted successfully.");
        } catch (\Exception $e) {
             session()->flash('message', $e->getMessage());
        }

    }


    public function render()
    {
        $query = auth()->user()->actors()->with(['contentItems']);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->contentItemFilter) {
            $query->whereHas('contentItems', function ($q) {
                $q->where('content_items.id', $this->contentItemFilter);
            });
        }

        $actors = $query->orderBy('updated_at', 'desc')
                        ->paginate(8)->withQueryString();

        $contentItems = auth()->user()->contentItems()->get();

        return view('livewire.actors.index', compact('actors', 'contentItems'));
    }
}
