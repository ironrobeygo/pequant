<?php

namespace App\Http\Livewire\Calendar;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Course;
use Livewire\Component;

class Index extends Component
{
    public $now;
    public $events;
    public $isEditModal;
    public $isShowModal;
    public $gotoDateModal;
    public $selectedDate;
    public $title;
    public $event_link;
    public $start_time;
    public $end_time;
    public $description;
    public $navigate;
    public $months;
    public $currMonth;
    public $currYear;
    public $courses;
    public $course_id;
    public $selectedEvent;
    public $gotoDate;
    public $selectedMonth;
    public $selectedYear;

    protected $listeners = ['openModal', 'isGotoDateModal', 'showModal', "refreshCalendar"];

    public function mount(){
        $this->selectedEvent = [];
        $this->now = Carbon::now();
        $this->title = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->description = '';
        $this->course_id = 0;
        $this->isShowModal = false;
        $this->gotoDateModal = false;
        $this->navigate = true;
        $this->selectedYear = $this->now->format('Y');
        $courses = Course::where('isOnline', 1)->whereNull('deleted_at')->orderBy('name', 'asc')->get();
        $this->courses = $courses;
    }

    public function render()
    {

        if( auth()->user()->hasRole('student') ){
            $events = Event::select('id','title','start')->WhereIn('course_id', auth()->user()->studentCourses->pluck('id')->toArray())->get();
        } else {
            $events = Event::select('id','title','start')->get();
        }

        $this->events = json_encode($events);

        return view('livewire.calendar.index');
    }

    public function isGotoDateModal(){
        $this->gotoDateModal = true;
    }

    public function initiateGotoDate(){
        $newDate = $this->selectedYear.'-'.$this->selectedMonth.'-01';
        $this->gotoDateModal = false;
        $this->dispatchBrowserEvent('initiateGotoDate', ['newDate' => $newDate]);
    }

    public function showModal(Event $event){
        $this->selectedEvent = $event;
        $this->isShowModal = true;
    }

    public function closeModal(){
        $this->title = '';
        $this->event_link = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->description = '';
        $this->selectedDate = false;
        $this->selectedEvent = [];
        $this->isShowModal = false;
        $this->gotoDateModal = false;
    }

    public function refreshCalendar(){
        $events = Event::select('id','title','start')->get();
        $this->events = json_encode($events);        
    }

    public function viewEvent($id){
        return redirect()->to('/events/'.$id.'/edit/');
    }

    public function deleteEvent(){
        $this->selectedEvent->delete();
        return redirect()->to('/events');
    }

}
