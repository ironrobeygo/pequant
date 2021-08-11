<?php

namespace App\Http\Livewire\Courses;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Category;
use App\Models\Institution;

class Edit extends Component
{
    public $categories = [];
    public $institutions = [];
    public $instructors = [];
    public $course;
    public $name;
    public $description;
    public $category_id;
    public $institution_id;
    public $instructor_id;

    protected $listeners = [
        'updateInstitutionIds',
        'updateInstructors'
    ];

    public function mount(Course $course){

        $this->course           = $course;
        $this->name             = $this->course->name;
        $this->description      = $this->course->description;
        $this->category_id      = $this->course->category->id;
        $this->institution_id   = $this->course->institution_id;
        $this->instructor_id    = $this->course->instructor_id;
        $this->categories       = Category::all();
        $this->institutions     = Institution::all();
        $this->instructors      = $this->getInstructors();

    }

    public function render()
    {
        return view('livewire.courses.edit');
    }

    public function editCourse(){

        $this->validate();

        $data = [
            'name'          => $this->name,
            'description'   => $this->description,
            'institution_id'=> $this->institution_id,
            'instructor_id' => $this->instructor_id,
            'category_id'   => $this->category_id,
            'updated_by'    => auth()->user()->id,
            'status'        => Course::PENDING,
            'isOnline'      => Course::OFFLINE
        ];

        $this->course->update($data);

        // return $course;
        return redirect()->to('/courses/'.$this->course->id.'/edit');

    }

    public function updateInstructors(){
        $this->instructors = $this->getInstructors();
    }

    public function getInstructors(){
        return User::where('institution_id', $this->institution_id)->role('instructor')->get();
    }

    protected function rules(){
        return [
            'name'          => 'required',
            'description'   => 'nullable',
            'category_id'   => 'required',
            'institution_id' => 'required',
            'instructor_id' => 'required'
        ];
    }
}
