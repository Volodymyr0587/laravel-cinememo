<?php

namespace App\Livewire\Admin\Professions;

use Livewire\Component;
use App\Models\Profession;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public string $name = '';
    public string $description = '';

    public function save()
    {
        $this->authorize('create', Profession::class);

        // Normalize BEFORE validation
        $this->name = trim(mb_strtolower($this->name));

        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('professions'),
            ],
            'description' => ['nullable', 'string']
        ]);

        $profession = Profession::create($validated);

        return redirect()->route('admin.professions.index')
                        ->with('success',"Genre {$profession->name} created successfully");
    }

    public function render()
    {
        return view('livewire.admin.professions.create');
    }
}
