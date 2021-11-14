<?php

namespace App\Http\Livewire\User\Student\Gradebook;

use Livewire\Component;

class Index extends Component
{
    public $user;
    public $scores;

    public function mount(){
        $this->user = auth()->user();
        $this->scores = $this->user->scores()->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.user.student.gradebook.index');
    }
}
