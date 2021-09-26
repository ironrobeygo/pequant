<?php

namespace App\Listeners;

use App\Models\Activity;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogFailedLogin
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        if( !$event->user ){
            return false;
        }

        Activity::create([
            'user_id' => $event->user->id,
            'event' => 'has failed to login',
        ]);
    }
}
