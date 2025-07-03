<?php

namespace App\Livewire\ContentTypes;

use App\Models\ContentType;
use Livewire\Component;

class Create extends Component
{
    public $name = '';

    protected $rules = [
        'name' => 'required|string|min:2|max:100|unique:content_types,name',
    ];

    public function save()
    {
        $this->validate();

        ContentType::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
        ]);

        session()->flash('message', 'Content type created successfully.');

        return redirect()->route('content-types.index');
    }

    public function render()
    {
        return view('livewire.content-types.create');
    }
}
