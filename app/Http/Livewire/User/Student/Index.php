<?php

namespace App\Http\Livewire\User\Student;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Institution;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $institutionFilter = 0;
    public $institutions;
    public $institution;
    public $courses = [];
    public $selectedCourse;
    public $student;
    public $deleteUser = '';
    public $isShowEnrolmentModal;
    public $isShowUnEnrolmentModal;
    public $isDeleteModal;

    public $listeners = ["updatedList" => 'render'];

    public function mount(){
        $this->isShowEnrolmentModal = false;
        $this->isShowUnEnrolmentModal = false;
        $this->isDeleteModal = false;
    }

    public function render()
    {
        $institutionFilter = $this->institutionFilter;

        $this->institutions = Institution::all();

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

        $this->isShowEnrolmentModal = true;
        $this->student = User::find($id);
        $institution_id = $this->student->institution_id;

        $this->courses = Course::whereHas('institution', function($query) use($institution_id){
                $query->where('institution_id', $institution_id);
            })
            ->where('isOnline', 1)
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->get();

    }

    public function showModalUnEnrolment($id){

        $this->isShowUnEnrolmentModal = true;
        $this->student = $id;
        $studentCourses = User::where('id', $this->student)->first()->studentCourses()->pluck('course_id')->unique();
        $this->courses = Course::whereIn('id', $studentCourses)->get();

    }

    public function processEnrolment(){

        $course = Course::find($this->selectedCourse);
        $course->enrolStudent($this->student);

        $this->isShowEnrolmentModal = false;

    }

    public function processUnEnrolment(){
        $course = Course::find($this->selectedCourse);
        $course->unEnrolStudent($this->student);
        $this->isShowUnEnrolmentModal = false;
    }

    public function closeModal(){
        $this->isShowEnrolmentModal = false;
        $this->isShowUnEnrolmentModal = false;
        $this->isDeleteModal = false;
    }

    public function resetTable(){
        $this->institutionFilter = 0;
        $this->perPage = 10;
        $this->search = '';
        $this->orderBy = 'id';
        $this->orderAsc = false;
        $this->emitSelf('updatedList');
    }

    public function delete(User $user){
        $this->isDeleteModal = true;
        $this->deleteUser = $user;
    }

    public function confirmDelete(){
        if(is_object($this->deleteUser)){
            $this->deleteUser->delete();
            $this->emitSelf('updatedList');
            $this->deleteUser = '';
            $this->isDeleteModal = false;
        }
    }

}
