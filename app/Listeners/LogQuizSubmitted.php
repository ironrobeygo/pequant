<?php

namespace App\Listeners;

use App\Models\Activity;
use App\Events\QuizSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogQuizSubmitted
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
     * @param  QuizSubmitted  $event
     * @return void
     */
    public function handle(QuizSubmitted $event)
    {
        Activity::create([
            'user_id' => $event->student->id,
            'event' => 'has submitted '.$event->quiz->name,
        ]);
    }
}
