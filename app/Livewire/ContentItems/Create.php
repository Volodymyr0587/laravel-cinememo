<?php

namespace App\Livewire\ContentItems;

use App\Models\ContentItem;
use App\Models\ContentType;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $content_type_id = '';
    public $title = '';
    public $description = '';
    public $image;
    public $status = 'willwatch';
    public $additional_images = [];

    protected $rules = [
        'content_type_id' => 'required|exists:content_types,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048', // 2MB max
        'status' => 'required|in:watching,watched,willwatch',
        'additional_images.*' => 'nullable|image|max:2048',
    ];

    public function save()
    {
        $this->validate();

        // Verify the content type belongs to the authenticated user
        $contentType = ContentType::where('id', $this->content_type_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('content-images', 'public');
        }

        $contentItem = ContentItem::create([
            'content_type_id' => $this->content_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imagePath,
            'status' => $this->status,
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
