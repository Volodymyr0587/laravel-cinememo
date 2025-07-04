<?php

namespace App\Livewire\ContentTypes;

use Livewire\Component;
use App\Models\ContentType;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public ContentType $contentType;
    public $name = '';

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('content_types')
                    ->ignore($this->contentType->id)
                    ->where(fn($query) => $query->where('user_id', auth()->id()))
            ],
        ];
    }

    public function mount(ContentType $contentType)
    {
        // Ensure the content type belongs to the authenticated user
        if ($contentType->user_id !== auth()->id()) {
            abort(404);
        }

        $this->contentType = $contentType;
        $this->name = $contentType->name;
    }

    public function save()
    {
        $this->validate();

        $this->contentType->update([
            'name' => $this->name,
        ]);

        session()->flash('message', 'Content type updated successfully.');

        return redirect()->route('content-types.index');
    }

    public function render()
    {
        return view('livewire.content-types.edit');
    }
}
