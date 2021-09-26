<?php

namespace App\Listeners;

use App\Models\Activity;
use App\Events\CourseAccess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogCourseAccess
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
     * @param  CourseAccess  $event
     * @return void
     */
    public function handle(CourseAccess $event)
    {
        Activity::create([
            'user_id' => $event->user->id,
            'event' => 'has accessed the course '. $event->course->name,
        ]);
    }
}
