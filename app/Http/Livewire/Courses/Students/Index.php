<?php

namespace App\Http\Livewire\Courses\Students;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $course;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $institutionFilter = 0;
    public $selected = [];

    protected $listeners = ['deleted' => 'render'];

    public function mount(Course $course){
        $this->course = $course;
    }

    public function render()
    {

        $institutionFilter = $this->institutionFilter;
        $searchFilter = $this->search;

        $students = $this->course->students()
            ->when($this->search, function($query) use($searchFilter){
                return $query->where('name', 'like', '%'.$searchFilter.'%');
            })
            ->when(auth()->user()->hasRole('instructor'), function($query){
                return $query->where('institution_id', auth()->user()->institution_id);
            })
            ->when($this->institutionFilter, function($query) use($institutionFilter){
                return $query->where('institution_id', $institutionFilter);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);

        return view('livewire.courses.students.index', compact('students'));
    }

    public function userDelete($id){

        $user = User::find($id);
        $user->delete();
        $this->emitSelf('deleted');

    }
}
