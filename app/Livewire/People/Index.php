<?php

namespace App\Livewire\People;

use App\Models\Person;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $contentItemFilter = '';

    public function clearFilters(): void
    {
        $this->search = '';
        $this->contentItemFilter = '';
    }


    public function delete($id)
    {
        try {
            $person = Person::where('user_id', auth()->id())->findOrFail($id);
            $person->removeAllImages();
            $person->delete();

            session()->flash('message', "Person $person->name deleted successfully.");
        } catch (\Exception $e) {
             session()->flash('message', $e->getMessage());
        }

    }


    public function render()
    {
        $query = auth()->user()->people()->with(['contentItems']);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->contentItemFilter) {
            $query->whereHas('contentItems', function ($q) {
                $q->where('content_items.id', $this->contentItemFilter);
            });
        }

        $people = $query->orderBy('updated_at', 'desc')
                        ->paginate(8)->withQueryString();

        $contentItems = auth()->user()->contentItems()->get();

        return view('livewire.people.index', compact('people', 'contentItems'));
    }
}
