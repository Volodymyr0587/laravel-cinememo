<?php

namespace App\Livewire\ContentItems;

use App\Models\ContentItem;
use App\Models\ContentType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public ContentItem $contentItem;
    public $content_type_id = '';
    public $title = '';
    public $description = '';
    public $image;
    public $status = '';
    public $existingImage = '';

    protected $rules = [
        'content_type_id' => 'required|exists:content_types,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'status' => 'required|in:watching,watched,willwatch',
    ];

    public function mount(ContentItem $contentItem)
    {
        // Ensure the content item belongs to the authenticated user
        $this->authorize('view', $contentItem);

        $this->contentItem = $contentItem;
        $this->content_type_id = $contentItem->content_type_id;
        $this->title = $contentItem->title;
        $this->description = $contentItem->description;
        $this->status = $contentItem->status->value;
        $this->existingImage = $contentItem->image;
    }

    public function removeImage()
    {
        if ($this->existingImage) {
            Storage::disk('public')->delete($this->existingImage);
            $this->contentItem->update(['image' => null]);
            $this->existingImage = '';
        }
    }

    public function save()
    {
        $this->validate();

        // Verify the content type belongs to the authenticated user
        $contentType = ContentType::where('id', $this->content_type_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $imagePath = $this->existingImage;

        if ($this->image) {
            // Delete old image if exists
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $imagePath = $this->image->store('content-images', 'public');
        }

        $this->contentItem->update([
            'content_type_id' => $this->content_type_id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imagePath,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Content item updated successfully.');

        return redirect()->route('content-items.index');
    }

    public function render()
    {
        $contentTypes = ContentType::where('user_id', auth()->id())->get();

        return view('livewire.content-items.edit', compact('contentTypes'));
    }
}
