<?php

namespace App\Http\Livewire\User\Student;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $institutionFilter = 0;
    public $institution;
    public $courses = [];
    public $selectedCourse;
    public $student;

    public function render()
    {
        $institutionFilter = $this->institutionFilter;

        $students = User::search($this->search)
            ->whereHas("roles", function($q){ 
                $q->where("name", "Student"); }
            )
            ->when($this->institutionFilter, function($query) use($institutionFilter){
                return $query->where('institution_id', $institutionFilter);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);

        return view('livewire.user.student.index', compact('students'));
    }

    public function showModalEnrolment($id){

        $this->student = $id;
        $institutions = User::where('id', $this->student)
            ->get()
            ->pluck('institution_id')
            ->unique();

        $this->courses = Course::whereHas('institutions', function($query) use($institutions){
                $query->whereIn('institution_id', $institutions);
            })
            ->get();

    }

    public function showModalUnEnrolment($id){

        $this->student = $id;
        $studentCourses = User::where('id', $this->student)->first()->studentCourses()->pluck('course_id')->unique();
        $this->courses = Course::whereIn('id', $studentCourses)->get();

    }

    public function processEnrolment(){

        $course = Course::find($this->selectedCourse);
        $course->enrolStudent($this->student);

    }

    public function processUnEnrolment(){
        $course = Course::find($this->selectedCourse);
        $course->unEnrolStudent($this->student);
    }

}
