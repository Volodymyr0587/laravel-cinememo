<?php

namespace App\Livewire\People;

use App\Models\Person;
use Livewire\Component;

class Show extends Component
{
    public Person $person;

    public function mount(Person $person)
    {
        $this->authorize('view', $person);

        $this->person = $person;
    }

    public function delete()
    {
        $this->authorize('delete', $this->person);

        $this->person->removeAllImages();
        $this->person->delete();

        session()->flash('message', __('people/show.person_deleted_message', ['name' => $this->person->name]));

        $this->redirectRoute('people.index');
    }

    public function render()
    {
        return view('livewire.people.show');
    }
}
