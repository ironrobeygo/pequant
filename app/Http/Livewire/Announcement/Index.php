<?php

namespace App\Http\Livewire\Announcement;

use Livewire\Component;
use App\Models\Announcement;

class Index extends Component
{
    public $perPage;
    public $search;
    public $orderBy = 'id';
    public $orderAsc = false;

    public function mount(){
        $this->perPage = 5;
        $this->search = '';
        $this->orderBy = 'id';
        $this->orderAsc = false;
    }   
     
    public function render()
    {
        $announcements = Announcement::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
        return view('livewire.announcement.index', compact('announcements'));
    }

    public function updateStatus($id){
        $announcement = Announcement::find($id);
        $announcement->status = !$announcement->status;
        $announcement->save();

    }
}
