<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title = '';
    public $introduction = '';
    public $main = '';
    public $conclusion = '';
    public $is_published = false;
    public $main_image;
    public $additional_images = [];
    public $tags = '';


    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'introduction' => 'required|string',
            'main' => 'required|string',
            'conclusion' => 'nullable|string',
            'is_published' => 'boolean',
            'main_image' => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
            'tags'  => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->authorize('create', Article::class);

        $this->validate();

        // Створюємо Article
        $article = auth()->user()->articles()->create([
            'title' => $this->title,
            'introduction' => $this->introduction,
            'main' => $this->main,
            'conclusion' => $this->conclusion,
            'is_published' => $this->is_published,
        ]);

        // Додаємо головне зображення через нову поліморфну систему
        if ($this->main_image) {
            $mainImagePath = $this->main_image->store('articles', 'public');
            $article->addMainImage($mainImagePath);
        }

        // Додаємо додаткові зображення через нову поліморфну систему
        foreach ($this->additional_images as $file) {
            $path = $file->store('articles', 'public');
            $article->addAdditionalImage($path);
        }

        // Зберігаємо tags
        $article->syncTags($this->tags);

        session()->flash('message', "Article $article->name has been added to your list of actors.");

        return redirect()->route('writer.articles.index');
    }

    public function render()
    {
        return view('livewire.articles.create');
    }
}
