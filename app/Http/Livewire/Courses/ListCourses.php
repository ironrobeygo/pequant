<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class ListCourses extends Component
{
    use WithPagination;
    
    public $perPage = 5;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        if(auth()->user()->hasRole('instructor')){
            $courses = auth()->user()->instructorCourses()->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage); 
        } else if(auth()->user()->hasRole('student')){
            $courses = auth()->user()->studentCourses()->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
        } else {
            $courses = Course::search($this->search)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
        }

        return view('livewire.courses.list-courses', compact('courses'));
    }

    public function updateStatus($id){
        
        $course = Course::find($id);
        $course->status = !$course->status;
        $course->save();

    }

    public function updateIsOnline($id){
        $course = Course::find($id);
        $course->isOnline = !$course->isOnline;
        $course->save();
    }
}
