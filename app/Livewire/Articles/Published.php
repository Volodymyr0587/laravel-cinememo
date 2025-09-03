<?php

namespace App\Livewire\Articles;

use App\Models\User;
use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Published extends Component
{
    use WithPagination;

    public $search = '';
    public $authorFilter = '';

    public function clearFilters(): void
    {
        $this->search = '';
        $this->authorFilter = '';
    }

    public function render()
    {
        $query = Article::with(['user'])->where('is_published', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->authorFilter) {
            $query->whereHas('user', function ($q) {
                $q->where('id', $this->authorFilter);
            });
        }

        $articles = $query->orderBy('updated_at', 'desc')
                        ->paginate(8)->withQueryString();

        $authors = User::role('writer')->get();

        // $contentItems = auth()->user()->contentItems()->get();
        return view('livewire.articles.published', compact('articles', 'authors'));
    }
}
