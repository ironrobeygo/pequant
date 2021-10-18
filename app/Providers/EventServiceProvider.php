<?php

namespace App\Providers;

use App\Models\Unit;
use App\Models\Question;
use App\Events\QuizOpened;
use App\Events\UnitOpened;
use App\Events\CourseAccess;
use App\Events\QuizSubmitted;
use App\Events\UnitCompleted;
use App\Observers\UnitObserver;
use App\Listeners\LogQuizOpened;
use App\Listeners\LogUnitOpened;
use App\Listeners\LogCourseAccess;
use App\Listeners\LogQuizSubmitted;
use App\Listeners\LogUnitCompleted;
use App\Observers\QuestionObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogSuccessfulLogout',
        ],
        'Illuminate\Auth\Events\Failed' => [
            'App\Listeners\LogFailedLogin',
        ],
        QuizSubmitted::class => [
            LogQuizSubmitted::class,
        ],
        CourseAccess::class => [
            LogCourseAccess::class
        ],
        QuizOpened::class => [
            LogQuizOpened::class
        ],
        UnitOpened::class => [
            LogUnitOpened::class
        ],
        UnitCompleted::class => [
            LogUnitCompleted::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Unit::observe(UnitObserver::class);
        Question::observe(QuestionObserver::class);
    }
}
