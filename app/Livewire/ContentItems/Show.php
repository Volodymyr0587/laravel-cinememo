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

        session()->flash('message', 'Content item deleted successfully.');

        $this->redirectRoute('content-items.index');

    }

    public function render()
    {
        return view('livewire.content-items.show');
    }
}
