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
    public $deleteCourse = '';

    public $listeners = ["updatedList" => 'render'];

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

        $name = $course->name;
        $chapters = $course->chapters;

        $clone = $course->replicate()->fill([
            'name' => $name . ' - copy',
            'user_id' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);
        $clone->save();

        foreach($chapters as $chapter){
            $units = $chapter->units;
            $quizzes = $chapter->quizzes;

            $cloneChapter = $chapter->replicate()->fill([

            ]);
            $cloneChapter->course_id = $clone->id;
            $cloneChapter->user_id = auth()->user()->id;
            $cloneChapter->updated_by = auth()->user()->id;
            $cloneChapter->status = 0;
            $cloneChapter->save();

            foreach($units as $unit){
                $cloneUnit = $unit->replicate();
                $cloneUnit->chapter_id = $cloneChapter->id;
                $cloneUnit->user_id = auth()->user()->id;
                $cloneUnit->updated_by = auth()->user()->id;
                $cloneUnit->status = 0;
                $cloneUnit->save();
            }

            foreach($quizzes as $quiz){
                $questions = $quiz->questions;

                $cloneQuiz = $quiz->replicate();
                $cloneQuiz->chapter_id = $cloneChapter->id;
                $cloneQuiz->user_id = auth()->user()->id;
                $cloneQuiz->updated_by = auth()->user()->id;
                $cloneQuiz->status = 0;
                $cloneQuiz->save();

                foreach($questions as $question){
                    $cloneQuestion = $question->replicate();
                    $cloneQuestion->quiz_id = $cloneQuiz->id;
                    $cloneQuestion->user_id = auth()->user()->id;
                    $cloneQuestion->updated_by = auth()->user()->id;
                    $cloneQuestion->status = 0;
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

    }

    public function delete(Course $course){
        $this->deleteCourse = $course;
    }

    public function confirmDelete(){

        if(is_object($this->deleteCourse)){
            $this->deleteCourse->delete();
            $this->emitSelf('updatedList');
            $this->deleteCourse = '';
        }

    }
}
