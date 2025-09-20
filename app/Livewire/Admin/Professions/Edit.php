<?php

namespace App\Livewire\Admin\Professions;

use Livewire\Component;
use App\Models\Profession;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Profession $profession;
    public string $name = '';
    public string $description = '';


    public function mount(Profession $profession)
    {
        $this->authorize('view', $profession);

        $this->profession = $profession;
        $this->name = $profession->name;
        $this->description = $profession->description ?? '';
    }

    public function save()
    {
        $this->authorize('update', $this->profession);

        // Normalize BEFORE validation
        $this->name = trim(mb_strtolower($this->name));

        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('professions')->ignore($this->profession->id)
            ],
            'description' => ['nullable', 'string']
        ]);

        $this->profession->update($validated);

        session()->flash('message', "Profession {$this->profession->name} updated successfully");

        return redirect()->route('admin.professions.index');
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
        return view('livewire.admin.professions.edit');
    }
}
