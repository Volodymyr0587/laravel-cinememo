<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Deleted extends Component
{
   use WithPagination;

    protected $listeners = ['refreshTrash' => '$refresh'];

    public function restore($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $article);

        $article->restore();

        session()->flash('message', 'Article restored successfully.');

        $this->dispatch('$refresh');
    }

    public function forceDelete($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $article);

        $article->removeAllImages();

        $article->forceDelete();

        session()->flash('message', 'Article permanently deleted.');

        $this->dispatch('$refresh');
    }
    public function render()
    {
        $query = Article::with(['user'])->onlyTrashed();

        $articles = $query->orderBy('deleted_at', 'desc')
                        ->paginate(8)->withQueryString();

        // $contentItems = auth()->user()->contentItems()->get();
        return view('livewire.articles.deleted', compact('articles'));
    }
}
