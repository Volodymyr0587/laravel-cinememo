<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use App\Models\ContentItem;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Trash extends Component
{
    use WithPagination;

    protected $listeners = ['refreshTrash' => '$refresh'];

    public function restore($id)
    {
        $contentItem = ContentItem::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $contentItem);

        $contentItem->restore();

        session()->flash('message', 'Content item restored successfully.');

        $this->dispatch('$refresh');
    }

    public function forceDelete($id)
    {
        $contentItem = ContentItem::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $contentItem);

        $contentItem->removeAllImages();

        $contentItem->forceDelete();

        session()->flash('message', 'Content item permanently deleted.');

        $this->dispatch('$refresh');
    }

    public function render()
    {
        $contentItems = ContentItem::onlyTrashed()
            ->whereHas('contentType', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('livewire.content-items.trash', [
            'contentItems' => $contentItems,
        ]);
    }
}
