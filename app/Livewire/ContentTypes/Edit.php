<?php

namespace App\Livewire\ContentTypes;

use Livewire\Component;
use App\Models\ContentType;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public ContentType $contentType;
    public $name = '';
    public $color = '#3b82f6';

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
            'color' => ['required'],
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
        $this->color = $contentType->color ?? '#3b82f6';
    }

    public function save()
    {
        $this->validate();

        $this->contentType->update([
            'name' => $this->name,
            'color' => $this->color,
        ]);

        session()->flash('message', __('content_types/edit.category_updated_message', ['name' => $this->name]));

        return redirect()->route('content-types.index');
    }

    public function render()
    {
        return view('livewire.content-types.edit');
    }
}
