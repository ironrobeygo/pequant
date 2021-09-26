<?php

namespace App\Observers;

use App\Models\Unit;
use App\Models\Chapter;

class UnitObserver
{
    /**
     * Handle the Unit "created" event.
     *
     * @param  \App\Models\Unit  $unit
     * @return void
     */
    public function created(Unit $unit)
    {

        if(is_null($unit->order)){
            $unit->order = Unit::where('chapter_id', $unit->chapter_id)->max('order') + 1;
            $unit->save();
            return;
        }

        $lowerPriorityUnits = Unit::where('chapter_id', $unit->chapter_id)
            ->where('order', '>=', $unit->order)
            ->get();

        foreach ($lowerPriorityUnits as $lowerPriorityUnit) {
            $lowerPriorityUnit->order++;
            $lowerPriorityUnit->saveQuietly();
        }
    }

    public function updated(Unit $unit)
    {
        if($unit->isClean('order') && $unit->isClean('chapter_id')){
            return;
        }

        $old = $unit->getOriginal();
        $oldChapterId = isset($old['chapter_id']) ? $old['chapter_id'] : $unit->chapter_id;
        $oldOrder = isset($old['order']) ? $old['order'] : $unit->order;

        if($oldChapterId != $unit->chapter_id){

            $oldChapterUnitOrderMax = Unit::where('chapter_id', $oldChapterId)->max('order');

            $oldOrderRange = [
                $oldOrder, $oldChapterUnitOrderMax
            ];

            $oldChapterUnits = Unit::where('chapter_id', $oldChapterId)
                ->whereBetween('order', $oldOrderRange)
                ->get();

            foreach ($oldChapterUnits as $oldChapterUnit) {
                $oldChapterUnit->order--;
                $oldChapterUnit->saveQuietly();
            }

            $lowerPriorityUnits = Unit::where('id', '!=', $unit->id)
                ->where('chapter_id', $unit->chapter_id)
                ->get();

            foreach ($lowerPriorityUnits as $lowerPriorityUnit) {
                if ($unit->order <= $lowerPriorityUnit->order) {
                    $lowerPriorityUnit->order++;
                }
                $lowerPriorityUnit->saveQuietly();
            }

        } else {

            if(is_null($unit->order)){
                $unit->order = Unit::where('chapter_id', $unit->chapter_id)->max('order');
            }

            if ($unit->getOriginal('order') > $unit->order) {
                $orderRange = [
                    $unit->order, $unit->getOriginal('order')
                ];
            } else {
                $orderRange = [
                    $unit->getOriginal('order'), $unit->order
                ];
            }

            $lowerPriorityUnits = Unit::where('id', '!=', $unit->id)
                ->where('chapter_id', $unit->chapter_id)
                ->whereBetween('order', $orderRange)
                ->get();

            foreach ($lowerPriorityUnits as $lowerPriorityUnit) {
                if ($unit->getOriginal('order') < $unit->order) {
                    $lowerPriorityUnit->order--;
                } else {
                    $lowerPriorityUnit->order++;
                }
                $lowerPriorityUnit->saveQuietly();
            }

        }
    }

    public function deleted(Unit $unit)
    {
        $lowerPriorityUnits = Unit::where('order', '>', $unit->order)
            ->where('chapter_id', $unit->chapter_id)
            ->get();

        foreach ($lowerPriorityUnits as $lowerPriorityUnit) {
            $lowerPriorityUnit->order--;
            $lowerPriorityUnit->saveQuietly();
        }
    }
}
