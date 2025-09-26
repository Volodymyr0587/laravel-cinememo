<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\CarbonInterval;
use App\Enums\ContentStatus;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use App\Services\RecommendationService;

class Dashboard extends Component
{
    public $recommendations;
    public $topGenres;

    public function mount()
    {
        $result = app(RecommendationService::class)->getRecommendationsForUser(auth()->user());

        $this->recommendations = $result['recommendations'];
        $this->topGenres = $result['genres'];
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
            'peopleCount' => $user->people()->count(),
            'lastUpdatedPerson' => $user->people()
                ->orderBy('people.updated_at', 'desc')
                ->select('people.name', 'people.updated_at')
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
            'timeOfContentViewed' => CarbonInterval::seconds($user->contentItems()
                ->where('status', ContentStatus::Watched->value)
                ->sum('duration_in_seconds'))->cascade()->forHumans(),
        ];
    }

    #[Computed]
    public function cinemaLevel(): array
    {
        return Auth::user()->cinema_level;
    }

    #[Computed]
    public function allCinemaLevels(): array
    {
        return Auth::user()->cinema_levels;
    }

    #[Computed]
    public function cinemaMessage(): string
    {
        $phrases = [
            "🎉 Congratulations! You’re now a",
            "🍿 Bravo! You’ve reached the level of",
            "🌟 Director’s Cut unlocked — welcome,",
            "🏆 You’re climbing the cinema ladder as a",
            "🎬 Another milestone achieved! Say hello to",
        ];

        return $phrases[array_rand($phrases)];
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'stats' => $this->stats,
            'cinemaLevel' => $this->cinemaLevel,
            'cinemaMessage' => $this->cinemaMessage,
            'allCinemaLevels' => $this->allCinemaLevels,
        ]);
    }
}
