<?php

namespace App\Http\Livewire\Courses;

use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use App\Models\Institution;

class Add extends Component
{

    public $categories = [];
    public $institutions = [];
    public $instructors = [];
    public $name;
    public $description;
    public $category_id;
    public $institution_id;
    public $instructor_id;

    public function mount(){
        $this->categories = Category::all();
        $this->institutions = Institution::all();        
    }

    public function render()
    {
        return view('livewire.courses.add');
    }

    public function updateInstructors(){
        $this->instructors = User::where('institution_id', $this->institution_id)->role('instructor')->get();
    }

    public function addCourse(){

        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'instructor_id' => $this->instructor_id,
            'institution_id' => $this->institution_id,
            'updated_by' => auth()->user()->id
        ];

        $course = auth()->user()->addCourse($data); 

        // return $course;
        return redirect()->to('/courses/'.$course->id);

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
