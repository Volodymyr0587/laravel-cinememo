<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use App\Models\ContentItem;
use Illuminate\Support\Facades\Storage;

class Show extends Component
{
    public ContentItem $contentItem;

    public function mount(ContentItem $contentItem)
    {
        $this->authorize('view', $contentItem);

        $this->contentItem = $contentItem;
    }

    public function delete($id)
    {
        $contentItem = ContentItem::whereHas('contentType', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $contentItem->delete();

        // session()->flash('message', 'Content item deleted successfully.');
        session()->flash('message', __('content_items/show.content_deleted_message', ['title' => $contentItem->title]));

        $this->redirectRoute('content-items.index');

    }

    public function render()
    {
        return view('livewire.content-items.show');
    }
}
