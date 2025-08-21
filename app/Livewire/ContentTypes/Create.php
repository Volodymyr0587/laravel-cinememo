<?php

namespace App\Livewire\ContentTypes;

use Livewire\Component;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $name = '';

    public $color;

    public function mount()
    {
        $this->color = '#3b82f6';
    }

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('content_types')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
            'color' => ['required'],
        ];
    }

    public function save()
    {
        $this->validate();

        $contentType = auth()->user()->contentTypes()->create([
            'name' => $this->name,
            'color' => $this->color,
        ]);

        session()->flash('message', "Category $contentType->name created successfully.");

        return redirect()->route('content-types.index');
    }

    public function render()
    {
        return view('livewire.content-types.create');
    }
}
