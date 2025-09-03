<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Article $article;

    public $title;
    public $body;
    public $is_published;
    public $main_image;
    public $additional_images = [];
    public $tags = [];

    public $new_main_image; // нове головне фото
    public $newAdditionalImages = [];
    public $confirmingMainImageRemoval = false;
    public $confirmingImageRemoval = false;
    public $imageIdToRemove = null;


    public function mount(Article $article)
    {
        $this->article = $article;

        $this->authorize('update', $article);

        $this->title = $article->title;
        $this->body = $article->body;
        $this->is_published = $article->is_published;
        // If you have tags relation
        // $this->tags = $article->tags()->pluck('id')->toArray();
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_published' => 'boolean',
            'main_image' => 'nullable|image|max:2048',
            'additional_images.*' => 'nullable|image|max:2048',
            // 'tags' => 'array',
            // 'tags.*' => 'exists:tags,id',
        ];
    }

    public function save()
    {
        $this->authorize('update', $this->article);

        $this->validate();

        // Оновлюємо дані статті
        $this->article->update([
            'title' => $this->title,
            'body' => $this->body,
            'is_published' => $this->is_published,
        ]);

        // Якщо нове головне зображення
        if ($this->main_image) {
            $mainImagePath = $this->main_image->store('articles', 'public');
            $this->article->addMainImage($mainImagePath); // другий параметр можна зробити щоб заміняти
        }

        // Додаємо додаткові зображення
        foreach ($this->additional_images as $file) {
            $path = $file->store('articles', 'public');
            $this->article->addAdditionalImage($path);
        }

        // Синхронізуємо теги
        // if (!empty($this->tags)) {
        //     $this->article->contentItems()->sync($this->tags);
        // }

        session()->flash('message', "Article {$this->article->title} updated successfully.");

        return redirect()->route('writer.articles.index');
    }


    public function confirmMainImageRemoval()
    {
        $this->confirmingMainImageRemoval = true;
    }

    public function removeMainImage()
    {
        $this->actor->removeMainImage();
        $this->confirmingMainImageRemoval = false;
        $this->actor->refresh();

        session()->flash('message', 'Main image removed successfully.');
    }

    public function confirmAdditionalImageRemoval($imageId)
    {
        $this->confirmingImageRemoval = true;
        $this->imageIdToRemove = $imageId;
    }

    public function deleteAdditionalImageConfirmed()
    {
        $this->actor->removeAdditionalImage($this->imageIdToRemove);

        $this->reset(['confirmingImageRemoval', 'imageIdToRemove']);
        $this->actor->refresh();

        session()->flash('message', 'Additional image removed successfully.');
    }
    public function render()
    {
        // $tags = Tag::where('user_id', auth()->id())
        //     ->orderBy('name')
        //     ->get();

        return view('livewire.articles.edit', [
            // 'tags' => $tags,
        ]);
    }
}
