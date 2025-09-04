<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ContentItem;
use App\Models\ContentType;

class PublicContentItems extends Component
{
    use WithPagination;

    public $search = '';
    public $publicContentTypeFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'publicContentTypeFilter' => ['except' => ''],
    ];

    // reset pagination when changing filters
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPublicContentTypeFilter()
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->publicContentTypeFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = ContentItem::with(['user', 'contentType'])
            ->where('is_public', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->publicContentTypeFilter) {
            $query->where('content_type_id', $this->publicContentTypeFilter);
        }

        // Додаємо likes_count з уникненням конфліктів кешування
        $query->withCount(['likes' => function ($query) {
            $query->selectRaw('count(*)');
        }]);

        $contentItems = $query->latest('created_at')->paginate(8)
            ->withQueryString();

        $contentTypes = ContentType::select('id','name','color')
            ->whereHas('contentItems', fn($q) => $q->where('is_public', true))
            ->orderBy('name')
            ->get();

        return view('livewire.content-items.public-content-items', compact('contentItems', 'contentTypes'));
    }
}
