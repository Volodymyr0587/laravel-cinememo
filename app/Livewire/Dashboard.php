<?php

namespace App\Livewire;

use App\Services\RecommendationService;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $recommendations;

    public function mount(RecommendationService $recommendations)
    {
        $this->recommendations = $recommendations->getRecommendationsForUser(Auth::user());
    }

    #[Computed]
    public function stats(): object
    {
        $user = Auth::user();

        return (object) [
            'contentItems' =>  $user->contentItems()
                ->latest('updated_at')
                ->take(8)
                ->get(),
            'contentItemsCount' => $user->contentItems()->count(),
            'actorsCount' => $user->actors()->count(),
            'lastUpdatedActor' => $user->actors()
                ->orderBy('actors.updated_at', 'desc')
                ->select('actors.name', 'actors.updated_at')
                ->first(),
            'lastUpdatedContentItem' => $user->contentItems()
                ->orderBy('content_items.updated_at', 'desc')
                ->select('content_items.title', 'content_items.updated_at')
                ->first(),
            'trashedContentItemsCount' => $user->contentItems()->onlyTrashed()->count(),
            'lastTrashedContentItem' => $user->contentItems()->onlyTrashed()
                ->orderBy('content_items.deleted_at', 'desc')
                ->select('content_items.title', 'content_items.deleted_at')
                ->first(),
            'contentTypesCount' => $user->contentTypes()->count(),
            'lastUpdatedContentType' => $user->contentTypes()
                ->latest('updated_at')
                ->select('name', 'updated_at')
                ->first(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'stats' => $this->stats,
        ]);
    }
}
