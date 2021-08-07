<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Livewire\Component;
use App\Models\Category;
use App\Models\Institution;

class Edit extends Component
{
    public $course;
    public $name;
    public $description;
    public $category_id;
    public $institution_ids;
    public $instructor_ids;

    protected $listeners = [
        'updateInstitutionIds',
        'updateInstructors'
    ];

    public function mount($course){

        $this->course = $course;
        $this->name = $this->course->name;
        $this->description = $this->course->description;
        $this->category_id = $this->course->category->id;
        $this->institution_ids = $this->course->institutions()->pluck('id');
        $this->instructor_ids = $this->course->instructors()->pluck('id');

    }

    public function render()
    {
        $categories = Category::all();
        $institutions = Institution::all();
        
        return view('livewire.courses.edit', 
            compact(
                'categories', 
                'institutions'
            )
        );
    }

    public function editCourse(){

        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'updated_by' => auth()->user()->id,
            'status'    => Course::PENDING,
            'isOnline' => Course::OFFLINE
        ];

        $this->course->update($data);

        $this->course->syncInstitutions($this->institution_ids);
        $this->course->syncInstructors($this->instructor_ids);

        // return $course;
        return redirect()->to('/courses/'.$this->course->id.'/edit');

    }

    public function updateInstructors($instructor_ids){
        $this->instructor_ids = $instructor_ids;
    }

    public function updateInstitutionIds($institution_ids){
        $this->institution_ids = $institution_ids;
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
