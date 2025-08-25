<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Livewire\Component;

class Show extends Component
{
    public Actor $actor;

    public function mount(Actor $actor)
    {
        $this->authorize('view', $actor);

        $this->actor = $actor;
    }

    public function delete(Actor $actor)
    {
        $this->authorize('delete', $actor);

        $actor->removeAllImages();

        $actor->delete();

        session()->flash('message', "Actor $actor->name deleted successfully.");

        $this->redirectRoute('actors.index');

    }
    public function render()
    {
        return view('livewire.actors.show');
    }
}
