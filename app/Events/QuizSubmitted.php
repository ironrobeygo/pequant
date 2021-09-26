<?php

namespace App\Events;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class QuizSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $student;
    public $quiz;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $student, Quiz $quiz)
    {
        $this->student = $student;
        $this->quiz = $quiz;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
