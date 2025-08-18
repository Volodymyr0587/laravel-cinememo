<?php

namespace App\Livewire\ContentItems;

use App\Models\ContentItem;
use App\Models\ContentType;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $contentTypeFilter = '';
    public $genreFilter = '';


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingContentTypeFilter()
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->statusFilter = '';
        $this->contentTypeFilter = '';
        $this->search = '';
        $this->genreFilter = '';
    }

    public function delete($id)
    {
        $contentItem = ContentItem::whereHas('contentType', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $contentItem->delete();

        session()->flash('message', 'Content item deleted successfully.');
    }

    public function render()
    {
        $query = auth()->user()->contentItems()->with(['contentType', 'genres']);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->contentTypeFilter) {
            $query->where('content_type_id', $this->contentTypeFilter);
        }

        if ($this->genreFilter) {
            $query->whereHas('genres', function ($q) {
                $q->where('genres.id', $this->genreFilter);
            });
        }

        $contentItems = $query->orderBy('updated_at', 'desc')
                        ->paginate(8)->withQueryString();

        $contentTypes = ContentType::where('user_id', auth()->id())->get();

        return view('livewire.content-items.index', compact('contentItems', 'contentTypes'));
    }
}
