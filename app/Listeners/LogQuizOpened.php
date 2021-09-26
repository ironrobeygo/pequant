<?php

namespace App\Listeners;

use App\Models\Activity;
use App\Events\QuizOpened;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogQuizOpened
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
     * @param  QuizOpened  $event
     * @return void
     */
    public function handle(QuizOpened $event)
    {
        Activity::create([
            'user_id' => $event->user->id,
            'event' => 'has opened the '. $event->quiz->name .' in '. $event->quiz->chapter->course->name,
        ]);
    }
}
