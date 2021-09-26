<?php

namespace App\Listeners;

use App\Models\Activity;
use App\Events\UnitOpened;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUnitOpened
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
     * @param  UnitOpened  $event
     * @return void
     */
    public function handle(UnitOpened $event)
    {
        Activity::create([
            'user_id' => $event->user->id,
            'event' => 'has opened the unit '. $event->unit->name .' in '. $event->unit->chapter->course->name,
        ]);
    }
}
