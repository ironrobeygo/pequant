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

        $html = '<p style="margin: 0;"><span style="font-weight: bold;">Name</span>: '. $student->name.'</p>';
        $html .= '<p style="margin: 0;"><span style="font-weight: bold;">Course</span>: '.$quiz->chapter->course->name.'</p>';
        $html .= '<p style="margin: 0;"><span style="font-weight: bold;">Chapter</span>: '.$quiz->chapter->name.'</p>';
        $html .= '<p style="margin: 0;"><span style="font-weight: bold;">Quiz</span>: '.$quiz->name.'</p>';
        $html .= '<hr>';

        foreach($questions as $question){
            $html .= '<p style="margin-bottom: 0; font-weight: bold;">'.$count.'. '.strip_tags($question->question) . ($complete == 0 ? ' - <span style="'. ( $answers[$question->id]['point'] >= 1 ? 'color: green">Correct' : 'color: red">Incorrect') .'</span>' : '' )  .'</p>'; 

            if($question->type_id == 1){
                $html .= '<ul style="list-style: none; margin-left: 0; padding-left: 0; margin-top: 5px;">';
                $type = 'checkbox';
                $optionCounter = $question->options->pluck('answer')->filter(function($value, $key){
                    return $value == 1;
                });

                if($optionCounter->count() == 1){
                    $type = 'radio';
                }

                foreach($question->options as $option){
                    $html .= '<li style="line-height: 0;">';
                    if($type == 'checkbox'){
                        $html .= '<input type="checkbox" style="margin-right: 2px;" '.(in_array($option->id,json_decode($answers[$question->id]['answer'])) ? ' checked ' : '').' disabled>';
                    } else {
                        $html .= '<input type="radio" style="margin-right: 2px;"'.(in_array($option->id,json_decode($answers[$question->id]['answer'])) ? ' checked ' : '').'disabled>';
                    }
                    $html .= '<span style="display: inline-block; margin-top: -5px;">'.$option->value.'</span>';
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }

            if($question->type_id == 2){
                $html .= '<p style="margin-top: 0;">Answer: '.$answers[$question->id]['answer'].'</p>';
            }

            if($question->type_id == 3){
                $html .= '<a href="'.$student->getMedia('quiz')->where('id', $answers[$question->id]['answer'])->first()->getFullUrl().'" target="_blank">Click to view to download file</a><br>';
            }
                                    

            $count++;
        }

        $pdf->loadHTML($html);
        return $pdf->stream($student->name.'-'.$quiz->chapter->course->name.'-'.$quiz->chapter->name.'-'.$quiz->name.'.pdf');
    }
}
