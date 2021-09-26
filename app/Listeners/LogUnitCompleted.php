<?php

namespace App\Listeners;

use App\Models\Activity;
use App\Events\UnitCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUnitCompleted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UnitCompleted  $event
     * @return void
     */
    public function handle(UnitCompleted $event)
    {
        Activity::create([
            'user_id' => $event->user->id,
            'event' => 'has completed the unit '. $event->unit->name .' in '. $event->unit->chapter->course->name,
        ]);
    }
}
