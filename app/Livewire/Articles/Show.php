<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;

class Show extends Component
{
    public Article $article;

    public function mount(Article $article)
    {
        // Policy handles published/unpublished visibility
        $this->authorize('view', $article);

        $this->article = $article;
    }

    public function render()
    {
        return view('livewire.articles.show', [
            'article' => $this->article,
        ]);
    }
}
