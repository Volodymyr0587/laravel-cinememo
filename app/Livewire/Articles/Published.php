<?php

namespace App\Livewire\Articles;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Published extends Component
{
    use WithPagination;

    public $search = '';
    public $publishedAuthorFilter = '';
    public $publishedTagFilter = '';


    protected $queryString = [
        'search' => ['except' => ''],
        'publishedAuthorFilter' => ['except' => ''],
        'publishedTagFilter' => ['except' => ''],
    ];

    // reset pagination when changing filters
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPublishedAuthorFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPublishedTagFilter(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->publishedAuthorFilter = '';
        $this->publishedTagFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Article::with(['user'])->where('is_published', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->publishedAuthorFilter) {
            $query->whereHas('user', function ($q) {
                $q->where('id', $this->publishedAuthorFilter);
            });
        }

        if ($this->publishedTagFilter) {
            $query->whereHas('tags', function ($q) {
                $q->where('tags.id', $this->publishedTagFilter);
            });
        }

        $articles = $query->orderBy('updated_at', 'desc')
                        ->paginate(8)->withQueryString();

        $authors = User::role(['writer', 'admin', 'super_admin'])
            ->has('articles')
            ->get();

        $tags = Tag::whereHas('articles', function ($q) {
            $q->where('is_published', true);
        })
        ->orderBy('name')
        ->get();


        // $contentItems = auth()->user()->contentItems()->get();
        return view('livewire.articles.published', compact('articles', 'authors', 'tags'));
    }
}
