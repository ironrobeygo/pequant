<?php

namespace App\Http\Livewire\Courses;

use Livewire\Component;
use App\Models\Category;
use App\Models\Institution;

class Add extends Component
{

    public $name;
    public $description;
    public $category_id;
    public $institution_ids;
    public $instructor_ids;

    protected $listeners = [
        'updateInstitutionIds',
        'updateInstructors'
    ];

    public function render()
    {
        $categories = Category::all();
        $institutions = Institution::all();
        
        return view('livewire.courses.add', 
            compact(
                'categories', 
                'institutions'
            )
        );
    }

    public function updateInstructors($instructor_ids){
        $this->instructor_ids = $instructor_ids;
    }

    public function updateInstitutionIds($institution_ids){
        $this->institution_ids = $institution_ids;
    }

    public function addCourse(){

        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'instructor_ids' => $this->instructor_ids,
            'institution_ids' => $this->institution_ids,
            'updated_by' => auth()->user()->id
        ];

        $course = auth()->user()->addCourse($data); 

        $course->syncInstitutions($this->institution_ids);
        $course->syncInstructors($this->instructor_ids);

        // return $course;
        return redirect()->to('/courses/'.$course->id);

    }

    protected function rules(){
        return [
            'name'          => 'required',
            'description'   => 'nullable',
            'category_id'   => 'required',
            'institution_ids' => 'required',
            'instructor_ids' => 'required'
        ];
    }
}
