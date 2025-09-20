<?php

namespace App\Livewire\Admin\Professions;

use Livewire\Component;
use App\Models\Profession;

class Show extends Component
{
    public Profession $profession;

    public function mount(Profession $profession)
    {
        $this->authorize('view', $profession);

        $this->profession = $profession;
    }

    public function delete(int $professionId)
    {
        $profession = Profession::findOrFail($professionId);

        $this->authorize('delete', $profession);

        $profession->delete();

        session()->flash('message', "Profession '{$profession->name}' deleted successfully.");

        return redirect()->route('admin.professions.index');
    }

    public function render()
    {
        return view('livewire.admin.professions.show');
    }
}
