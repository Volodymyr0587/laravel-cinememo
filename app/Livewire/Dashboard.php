<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $contentItems;
    public $contentItemsCount;
    public $lastUpdatedContentItem;
    public $trashedContentItemsCount;
    public $contentTypesCount;
    public $lastUpdatedContentType;

    public function mount()
    {
        $user = Auth::user();

        $this->contentItems = $user->contentItems()
            ->latest('updated_at')
            ->take(8)
            ->get();

        $this->contentItemsCount = $user->contentItems()->count();

        $this->lastUpdatedContentItem = $user->contentItems()
            ->orderBy('content_items.updated_at', 'desc')
            ->select('content_items.title', 'content_items.updated_at')
            ->first();

        $this->trashedContentItemsCount = $user->contentItems()->onlyTrashed()->count();

        $this->contentTypesCount = $user->contentTypes()->count();

        $this->lastUpdatedContentType = $user->contentTypes()
            ->latest('updated_at')
            ->select('name', 'updated_at')
            ->first();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
