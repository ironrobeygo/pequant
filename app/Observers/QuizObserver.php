<?php

namespace App\Observers;

use App\Models\Quiz;

class QuizObserver
{
    /**
     * Handle the Quiz "created" event.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return void
     */
    public function created(Quiz $quiz)
    {
        if(is_null($quiz->order)){
            $quiz->order = Quiz::where('chapter_id', $quiz->chapter_id)->whereNull('deleted_at')->max('order') + 1;
            $quiz->save();
            return;
        } else {
            return false;
        }

        $lowerPriorityUnits = Quiz::where('chapter_id', $quiz->chapter_id)
            ->whereNull('deleted_at')
            ->where('order', '>=', $quiz->order)
            ->get();

        foreach ($lowerPriorityUnits as $lowerPriorityUnit) {
            $lowerPriorityUnit->order++;
            $lowerPriorityUnit->saveQuietly();
        }
    }

    /**
     * Handle the Quiz "updated" event.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return void
     */
    public function updated(Quiz $quiz)
    {
        if($quiz->isClean('order') && $quiz->isClean('chapter_id')){
            return;
        }

        $old = $quiz->getOriginal();
        $oldChapterId = isset($old['chapter_id']) ? $old['chapter_id'] : $quiz->chapter_id;
        $oldOrder = isset($old['order']) ? $old['order'] : $quiz->order;

        if($oldChapterId != $quiz->chapter_id){

            $oldChapterUnitOrderMax = Quiz::where('chapter_id', $oldChapterId)->whereNull('deleted_at')->max('order');

            $oldOrderRange = [
                $oldOrder, $oldChapterUnitOrderMax
            ];

            $oldChapterUnits = Quiz::where('chapter_id', $oldChapterId)
                ->whereNull('deleted_at')
                ->whereBetween('order', $oldOrderRange)
                ->get();

            foreach ($oldChapterUnits as $oldChapterUnit) {
                $oldChapterUnit->order--;
                $oldChapterUnit->saveQuietly();
            }

            $lowerPriorityUnits = Quiz::where('id', '!=', $quiz->id)
                ->where('chapter_id', $quiz->chapter_id)
                ->whereNull('deleted_at')
                ->get();

            foreach ($lowerPriorityUnits as $lowerPriorityUnit) {
                if ($quiz->order <= $lowerPriorityUnit->order) {
                    $lowerPriorityUnit->order++;
                }
                $lowerPriorityUnit->saveQuietly();
            }

        } else {

            if(is_null($quiz->order)){
                $quiz->order = Quiz::where('chapter_id', $quiz->chapter_id)->whereNull('deleted_at')->max('order');
            }

            if ($quiz->getOriginal('order') > $quiz->order) {
                $orderRange = [
                    $quiz->order, $quiz->getOriginal('order')
                ];
            } else {
                $orderRange = [
                    $quiz->getOriginal('order'), $quiz->order
                ];
            }

            $lowerPriorityUnits = Quiz::where('id', '!=', $quiz->id)
                ->where('chapter_id', $quiz->chapter_id)
                ->whereBetween('order', $orderRange)
                ->whereNull('deleted_at')
                ->get();

            foreach ($lowerPriorityUnits as $lowerPriorityUnit) {
                if ($quiz->getOriginal('order') < $quiz->order) {
                    $lowerPriorityUnit->order--;
                } else {
                    $lowerPriorityUnit->order++;
                }
                $lowerPriorityUnit->saveQuietly();
            }

        }
    }

    /**
     * Handle the Quiz "deleted" event.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return void
     */
    public function deleted(Quiz $quiz)
    {
        $lowerPriorityUnits = Quiz::where('order', '>', $quiz->order)
            ->where('chapter_id', $quiz->chapter_id)
            ->whereNull('deleted_at')
            ->get();

        foreach ($lowerPriorityUnits as $lowerPriorityUnit) {
            $lowerPriorityUnit->order--;
            $lowerPriorityUnit->saveQuietly();
        }
    }

}
