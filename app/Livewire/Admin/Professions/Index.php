<?php

namespace App\Livewire\Admin\Professions;

use Livewire\Component;
use App\Models\Profession;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function clearFilters(): void
    {
        $this->reset(['search']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(int $professionId)
    {
        $profession = Profession::findOrFail($professionId);

        $this->authorize('delete', $profession);

        $profession->delete();

        session()->flash('message', __("professions/main.delete_profession_message", ['name' => $profession->name]));

        return redirect()->route('admin.professions.index');
    }

    public function render()
    {
        $query = Profession::orderBy('name');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $allProfessions = $query->paginate(10)->withQueryString();

        return view('livewire.admin.professions.index', compact('allProfessions'));
    }
}
