<?php

namespace App\Http\Livewire\Institution;

use Livewire\Component;
use App\Models\Institution;

class Show extends Component
{
    public $schedules;

    public function mount(Institution $institution){
        $this->schedules = $institution->schedules;
    }

    public function render()
    {
        return view('livewire.institution.show');
    }
}
