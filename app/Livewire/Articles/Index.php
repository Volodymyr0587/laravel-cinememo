<?php

namespace App\Livewire\Articles;

use App\Models\User;
use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $authorFilter = '';

    public function clearFilters(): void
    {
        $this->search = '';
        $this->authorFilter = '';
    }


    public function delete($id)
    {
        try {
            $article = Article::findOrFail($id);

            $this->authorize('delete', $article);

            $article->removeAllImages();
            $article->delete();

            session()->flash('message', "Article '{$article->title}' deleted successfully.");
        } catch (\Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }


    public function render()
    {
        $query = Article::with(['user']);

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

        // Get users with permission to write articles
        $authors = User::role(['writer', 'admin', 'super_admin'])->get();

        return view('livewire.articles.index', compact('articles', 'authors'));
    }

}
