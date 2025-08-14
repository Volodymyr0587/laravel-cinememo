<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use App\Models\ContentItem;
use Livewire\WithPagination;

class PublicContentItems extends Component
{
    use WithPagination;

    public $search = '';
    public $contentTypeFilter = '';

    public function clearFilters(): void
    {
        $this->contentTypeFilter = '';
        $this->search = '';
    }

    public function render()
    {
        $query = ContentItem::with('user', 'contentType')
            ->where('is_public', true)
            // ->where('user_id', '!=', auth()->id())
            ;

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->contentTypeFilter) {
            $query->where('content_type_id', $this->contentTypeFilter);
        }

        $contentItems = $query->orderBy('updated_at', 'desc')
                        ->paginate(8)->withQueryString();

        return view('livewire.content-items.public-content-items', compact('contentItems'));
    }
}
