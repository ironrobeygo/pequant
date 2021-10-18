<?php

namespace App\Observers;

use App\Models\Question;

class QuestionObserver
{
    public function created(Question $question)
    {

        if(is_null($question->order)){
            $question->order = Question::where('quiz_id', $question->quiz_id)->whereNull('deleted_at')->max('order') + 1;
            $question->save();
            return;
        }

        $lowerPriorityQuestions = Question::where('quiz_id', $question->quiz_id)
            ->where('order', '>=', $question->order)
            ->whereNull('deleted_at')
            ->get();

        foreach ($lowerPriorityQuestions as $lowerPriorityQuestion) {
            $lowerPriorityQuestion->order++;
            $lowerPriorityQuestion->saveQuietly();
        }
    }

    public function updated(Question $question)
    {
        if($question->isClean('order')){
            return;
        }

        if ($question->getOriginal('order') > $question->order) {
            $orderRange = [
                $question->order, $question->getOriginal('order')
            ];
        } else {
            $orderRange = [
                $question->getOriginal('order'), $question->order
            ];
        }

        $lowerPriorityQuestions = Question::where('id', '!=', $question->id)
            ->whereBetween('order', $orderRange)
            ->whereNull('deleted_at')
            ->get();

        foreach ($lowerPriorityQuestions as $lowerPriorityQuestion) {
            if ($question->getOriginal('order') < $question->order) {
                $lowerPriorityQuestion->order--;
            } else {
                $lowerPriorityQuestion->order++;
            }
            $lowerPriorityQuestion->saveQuietly();
        }
    }

    public function deleted(Question $question)
    {
        $lowerPriorityQuestions = Question::where('order', '>', $question->order)
            ->where('quiz_id', $question->quiz_id)
            ->whereNull('deleted_at')
            ->get();

        foreach ($lowerPriorityQuestions as $lowerPriorityQuestion) {
            $lowerPriorityQuestion->order--;
            $lowerPriorityQuestion->saveQuietly();
        }
    }
}
