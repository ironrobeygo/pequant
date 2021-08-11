<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    protected $listeners = ['deleted' => 'render'];

    public function render()
    {
        $users = User::search($this->search)
            ->with('roles')
            ->whereHas('roles', function($query){
                $query->whereIn("name", ['admin','instructor']);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);
        return view('livewire.user.index', compact('users'));
    }

    public function userDelete(User $user){
        $user->delete();
        $this->emitSelf('deleted');
    }
}
