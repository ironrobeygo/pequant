<?php

namespace App\Http\Livewire\Form;

use Livewire\Component;
use Illuminate\Session\SessionManager;

class Multiselect extends Component
{
    public $object;
    public $placeholder;

    public function mount(SessionManager $session, $object, $placeholder){
        $this->object = $object;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('livewire.form.multiselect', [
            'object' => $this->object,
            'placeholder' => $this->placeholder
        ]);
    }
    
}
