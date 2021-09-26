<?php

namespace App\Http\Livewire\Announcement;

use Livewire\Component;
use App\Models\Announcement;

class Edit extends Component
{
    public $announce;
    public $name;
    public $announcement;

    public function mount(Announcement $announce){
        $this->announce = $announce;
        $this->name = $this->announce->name;
        $this->announcement = $this->announce->announcement;
    }

    public function render()
    {
        return view('livewire.announcement.edit');
    }

    protected function rules(){
        return [
            'name'          => 'required',
            'announcement'  => 'required'
        ];
    }
}
