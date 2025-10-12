<?php

namespace App\Livewire\ContentItems;

use App\Models\Genre;
use Livewire\Component;
use App\Models\ContentItem;
use App\Models\ContentType;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $contentTypeFilter = '';
    public $genreFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'contentTypeFilter' => ['except' => ''],
        'genreFilter' => ['except' => ''],
    ];

    // reset pagination when changing filters
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
        $this->resetPage();
    }

    public function delete($id)
    {
        $contentItem = ContentItem::whereHas('contentType', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $contentItem->delete();

        session()->flash('message', __('content_items/main.content_deleted_message', ['title' => $contentItem->title]));
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

        $genres = Genre::all();

        return view('livewire.content-items.index', compact('contentItems', 'contentTypes', 'genres'));
    }
}
