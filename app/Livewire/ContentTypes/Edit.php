<?php

namespace App\Livewire\ContentTypes;

use App\Models\ContentType;
use Livewire\Component;

class Edit extends Component
{
    public ContentType $contentType;
    public $name = '';

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

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
