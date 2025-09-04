<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ContentItem;
use App\Models\ContentType;
use Livewire\Attributes\On;

class PublicContentItems extends Component
{
    use WithPagination;

    public $search = '';
    public $contentTypeFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'contentTypeFilter' => ['except' => ''],
    ];

    // Додаємо властивість для примусового оновлення
    public $refreshKey = 0;

    public function clearFilters(): void
    {
        $this->search = '';
        $this->contentTypeFilter = '';
        $this->resetPage(); // Важливо: скидаємо пагінацію
        $this->refreshKey++; // Примусово оновлюємо компонент

        // Повідомляємо всі дочірні компоненти про необхідність оновлення
        $this->dispatch('refresh-likes');
    }

    // Додаємо методи для автоматичного скидання пагінації при зміні фільтрів
    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->refreshKey++;
        $this->dispatch('refresh-likes');
    }

    public function updatedContentTypeFilter(): void
    {
        $this->resetPage();
        $this->refreshKey++;
        $this->dispatch('refresh-likes');
    }

    // Слухач для оновлення з дочірніх компонентів
    #[On('like-updated')]
    public function handleLikeUpdate($likeableId = null)
    {
        // Можна додати додаткову логіку якщо потрібно
        $this->refreshKey++;
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

        // Додаємо likes_count з уникненням конфліктів кешування
        $query->withCount(['likes' => function ($query) {
            $query->selectRaw('count(*)');
        }]);

        $contentItems = $query->latest('created_at')->paginate(8);

        $contentTypes = ContentType::select('id','name','color')
            ->whereHas('contentItems', fn($q) => $q->where('is_public', true))
            ->orderBy('name')
            ->get();

        return view('livewire.content-items.public-content-items', compact('contentItems', 'contentTypes'));
    }
}
