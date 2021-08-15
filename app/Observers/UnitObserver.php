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

    /**
     * Handle the Unit "updated" event.
     *
     * @param  \App\Models\Unit  $unit
     * @return void
     */
    public function updated(Unit $unit)
    {
        if($unit->isClean('order')){
            return;
        }

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

        $lowerPriorityCategories = Unit::where('id', '!=', $unit->id)
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

    /**
     * Handle the Unit "deleted" event.
     *
     * @param  \App\Models\Unit  $unit
     * @return void
     */
    public function deleted(Unit $unit)
    {
        $lowerPriorityUnits = Unit::where('order', '>', $category->order)
            ->where('chapter_id', $unit->chapter_id)
            ->get();

        foreach ($lowerPriorityUnits as $lowerPriorityUnit) {
            $lowerPriorityUnit->order--;
            $lowerPriorityUnit->saveQuietly();
        }
    }
}
