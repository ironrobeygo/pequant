<?php

namespace App\Http\Controllers;

use App;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index(User $student, Quiz $quiz){
        $answers = $student->getQuizAnswers($quiz->id);

        $admins         = User::whereHas("roles", function($q){ $q->where("name", "admin"); })->get()->pluck('id')->toArray();
        $instructor     = $quiz->chapter->course->instructor->id;
        array_push($admins, $instructor);
        $questions      = $quiz->questions->where('status', 1)->whereIn('user_id', $admins);
        $complete       = $student->scores()->where('quiz_id', $quiz->id)->first()->completed;
        $count          = 1;

        $pdf = App::make('dompdf.wrapper');

        $data = [
            'questions' => $questions,
            'student'   => $student,
            'quiz'      => $quiz,
            'count'     => $count,
            'complete'  => $complete,
            'answers'   => $answers
        ];

        $pdf->loadView('records.show', $data);
        return $pdf->download($student->name.'-'.$quiz->chapter->course->name.'-'.$quiz->chapter->name.'-'.$quiz->name.'.pdf');
    }
}
