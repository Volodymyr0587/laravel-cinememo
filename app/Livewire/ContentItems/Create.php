<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use App\Models\ContentItem;
use App\Models\ContentType;
use App\Enums\ContentStatus;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class Create extends Component
{
    use WithFileUploads;

    public $content_type_id = '';
    public $title = '';
    public $description = '';
    public $image;
    public $status = 'willwatch';
    public $is_public = false;
    public $additional_images = [];

    protected function rules(): array
    {
        return [
            'content_type_id' => 'required|exists:content_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB max
            'status' => ['required', Rule::in(ContentStatus::values())],
            'is_public' => ['boolean'],
            'additional_images.*' => 'nullable|image|max:2048',
        ];
    }

    public function save()
    {
        $this->validate();

        $imagePath = $this->image ? $this->image->store('content-images', 'public') : null;

        $contentItem = ContentItem::create([
            'content_type_id' => $this->content_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imagePath,
            'status' => $this->status,
            'is_public' => $this->is_public,
        ]);

        foreach ($this->additional_images as $file) {
            $path = $file->store('content-images', 'public');
            $contentItem->additionalImages()->create(['path' => $path]);
        }

        session()->flash('message', 'Content item created successfully.');

        return redirect()->route('content-items.index');
    }

    public function render()
    {
        $contentTypes = ContentType::where('user_id', auth()->id())->get();

        return view('livewire.content-items.create', compact('contentTypes'));
    }
}
