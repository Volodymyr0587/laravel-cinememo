<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    // public $contentItemFilter = '';

    public function clearFilters(): void
    {
        $this->search = '';
        // $this->contentItemFilter = '';
    }


    public function delete($id)
    {
        try {
            $article = Article::where('user_id', auth()->id())->findOrFail($id);
            $article->removeAllImages();
            $article->delete();

            session()->flash('message', "Article $article->name deleted successfully.");
        } catch (\Exception $e) {
             session()->flash('message', $e->getMessage());
        }

    }


    public function render()
    {
        // $query = auth()->user()->actors()->with(['contentItems']);
        $query = Article::with(['user']);


        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        // if ($this->contentItemFilter) {
        //     $query->whereHas('contentItems', function ($q) {
        //         $q->where('content_items.id', $this->contentItemFilter);
        //     });
        // }

        $articles = $query->orderBy('updated_at', 'desc')
                        ->paginate(8)->withQueryString();

        // $contentItems = auth()->user()->contentItems()->get();

        return view('livewire.articles.index', compact('articles'));
    }
}
