<?php

namespace App\Http\Livewire\Institution;

use Livewire\Component;
use App\Models\Institution;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $perPage = 5;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        $institutions = Institution::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);
        return view('livewire.institution.index', compact('institutions'));
    }
}
