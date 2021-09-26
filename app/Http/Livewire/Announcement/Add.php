<?php

namespace App\Http\Livewire\Announcement;

use Livewire\Component;

class Add extends Component
{
    public $name;
    public $announcement;

    public function render()
    {
        return view('livewire.announcement.add');
    }

    public function addAnnouncement(){

        $this->validate();

        $data = [
            'name'          => $this->name,
            'announcement'  => $this->announcement
        ];

        $announcement = auth()->user()->addAnnouncement($data); 

        alert()->success('A new announcement has been created.', 'Congratulations!');

        // return $course;
        return redirect()->to('/announcements');

    }

    protected function rules(){
        return [
            'name'          => 'required',
            'announcement'  => 'required'
        ];
    }
}
