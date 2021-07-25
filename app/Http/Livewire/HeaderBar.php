<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HeaderBar extends Component
{

    public $isProfileMenuOpen = false;

    public function render()
    {
        return view('livewire.header-bar');
    }

    public function toggleProfileMenu(){
        $this->isProfileMenuOpen = true;
    }
}
