<?php

namespace App\Http\Livewire\Activity;

use Livewire\Component;
use App\Models\Activity;

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
        if( auth()->user()->hasRole('admin') ){
            $activities = Activity::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
        } else {
            $activities = Activity::whereHas('user', function($query){
                $query->where('institution_id', 1);
            })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        }
        

        return view('livewire.activity.index', compact('activities'));
    }
}
