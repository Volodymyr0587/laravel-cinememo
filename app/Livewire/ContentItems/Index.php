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

    public function delete($id)
    {
        $contentItem = ContentItem::whereHas('contentType', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        // Delete the image file if it exists
        if ($contentItem->image) {
            Storage::disk('public')->delete($contentItem->image);
        }

        // Delete all additional image files
        foreach ($contentItem->additionalImages as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $contentItem->delete();

        session()->flash('message', 'Content item deleted successfully.');
    }

    public function render()
    {
        $query = ContentItem::whereHas('contentType', function($query) {
            $query->where('user_id', auth()->id());
        })->with('contentType');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->contentTypeFilter) {
            $query->where('content_type_id', $this->contentTypeFilter);
        }

        $contentItems = $query->orderBy('updated_at', 'desc')
                        ->paginate(8)->withQueryString();

        $contentTypes = ContentType::where('user_id', auth()->id())->get();

        return view('livewire.content-items.index', compact('contentItems', 'contentTypes'));
    }
}
