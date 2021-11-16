<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ListCourses extends Component
{
    use WithPagination;
    
    public $perPage;
    public $search;
    public $orderBy;
    public $orderAsc;
    public $deleteCourse;
    public $showModal;

    public $listeners = ["updatedList" => 'render'];

    public function mount(){
        $this->perPage = 5;
        $this->search = '';
        $this->orderBy = 'id';
        $this->orderAsc = false;
        $this->deleteCourse = '';
        $this->showModal = false;
    }

    public function render()
    {
        if(auth()->user()->hasRole('instructor')){

            $courses = Course::where('instructor_id', auth()->user()->id)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

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

    public function clone(Course $course){

        try{

            $name = $course->name;

            DB::beginTransaction();

            $clone = $course->replicate()->fill([
                'name'          => $name . ' - copy',
                'user_id'       => auth()->user()->id,
                'updated_by'    => auth()->user()->id
            ]);
            $clone->save();

            foreach($course->chapters as $chapter){

                $units = $chapter->units->where('type', 'unit');
                $quizzes = $chapter->quizzes->where('type', 'quiz');

                $cloneChapter = $chapter->replicate()->fill([
                    'user_id'       => auth()->user()->id,
                    'updated_by'    => auth()->user()->id, 
                    'status'        => 0
                ]);
                $cloneChapter->course_id = $clone->id;
                $cloneChapter->save();

                foreach($units as $unit){
                    $cloneUnit = $unit->replicate()->fill([
                        'user_id'       => auth()->user()->id,
                        'updated_by'    => auth()->user()->id,
                        'status'        => 0
                    ]);
                    $cloneUnit->order = $unit->order;
                    $cloneUnit->chapter_id = $cloneChapter->id;
                    $cloneUnit->save();
                }

                foreach($quizzes as $quiz){
                    $questions = $quiz->questions;

                    $cloneQuiz = $quiz->replicate()->fill([
                        'user_id'       => auth()->user()->id,
                        'updated_by'    => auth()->user()->id,
                        'status'        => 0
                    ]);
                    $cloneQuiz->order = $quiz->order;
                    $cloneQuiz->chapter_id = $cloneChapter->id;
                    $cloneQuiz->save();

                    foreach($questions as $question){
                        $cloneQuestion = $question->replicate()->fill([
                            'user_id'   => auth()->user()->id,
                            'updated_by'=> auth()->user()->id,
                            'status'    => 0
                        ]);
                        $cloneQuestion->quiz_id = $cloneQuiz->id;
                        $cloneQuestion->save();

                        if($question->type_id == 1){

                            $options = $question->options;
                            $opts = array();

                            foreach($options as $option){
                                $cloneOption = $option->replicate();
                                $cloneOption->save();
                                $opts[] = $cloneOption->id;
                            }

                            $cloneQuestion->syncOptions($options);

                        }


                    }
                }

            }

            $this->emitSelf('updatedList');

            DB::commit();

            alert()->success($name.' course has been successfully cloned.', 'Congratulations!');

        } catch(QueryException $e){
            DB::rollback();
            alert()->error($e->getMessage(), 'Please try again!');

        } catch(ModelNotFoundException $h){
            DB::rollback();
            alert()->error($h->getMessage(), 'Please try again!');

        }

    }

    public function delete(Course $course){
        $this->deleteCourse = $course;
        $this->showModal = true;
    }

    public function confirmDelete(){

        if(is_object($this->deleteCourse)){
            $this->deleteCourse->delete();
            $this->emitSelf('updatedList');
            $this->deleteCourse = '';
            $this->showModal = false;
        }

    }

    public function closeModal(){
        $this->showModal = false;
    }
}
