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
    public $contentTypeFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'contentTypeFilter' => ['except' => ''],
    ];

    public function clearFilters(): void
    {
        $this->search = '';
        $this->contentTypeFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = ContentItem::with(['user', 'contentType'])
            ->where('is_public', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->contentTypeFilter) {
            $query->where('content_type_id', $this->contentTypeFilter);
        }

        // Додаємо likes_count лише один раз для сортування і відображення
        $query->withCount('likes');

        $contentItems = $query->latest()->paginate(8)->withQueryString();

        $contentTypes = ContentType::select('id','name','color')
            ->whereHas('contentItems', fn($q) => $q->where('is_public', true))
            ->orderBy('name')
            ->get();

        return view('livewire.content-items.public-content-items', compact('contentItems', 'contentTypes'));
    }
}
