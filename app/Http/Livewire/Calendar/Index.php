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
    public $isModalOpen;
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
        $this->isModalOpen = false;
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

    public function addEvent(){

        $this->validate();

        $selStart = Carbon::parse($this->selectedDate['dateStr'] . ' ' . $this->start_time)->format('Y-m-d H:i:s');
        $selEnd = Carbon::parse($this->selectedDate['dateStr'] . ' ' . $this->end_time)->format('Y-m-d H:i:s');

        $new_event = Event::create([
            'title' => $this->title,
            'url' => $this->event_link,
            'start' => $selStart,
            'end' => $selEnd,
            'description' => $this->description, 
            'user_id' => auth()->user()->id,
            'course_id' => $this->course_id
        ]);

        if( !$new_event ){
            alert()->error('An error has occurred', 'Please try again!');
        }

        alert()->success('A new event has been added to your calendar', 'Congratulations!');

        $this->title = '';
        $this->event_link = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->description = '';
        $this->course_id = 0;
        $this->selectedDate = false;
        $this->isModalOpen = false;

        $this->emit('refreshCalendar');
    }

    public function isGotoDateModal(){
        $this->gotoDateModal = true;
    }

    public function initiateGotoDate(){
        $newDate = $this->selectedYear.'-'.$this->selectedMonth.'-01';
        $this->gotoDateModal = false;
        $this->dispatchBrowserEvent('initiateGotoDate', ['newDate' => $newDate]);
    }

    public function openModal($date){
        $this->selectedDate = $date;
        $dateStr = Carbon::parse($date['dateStr']);
        $this->selectedDate['dateStr'] = $dateStr->format('l, F j, Y');
        $start_time = $end_time = $this->timeInterval($dateStr);
        
        array_pop($start_time);        
        $this->selectedDate['start_time'] = $start_time;
        array_shift($end_time);
        $this->selectedDate['end_time'] = $end_time;

        $this->isModalOpen = true;
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
        $this->isModalOpen = false;
        $this->selectedEvent = [];
        $this->isShowModal = false;
        $this->gotoDateModal = false;
    }

    protected function timeInterval($dateStr){

        $now = Carbon::now('Asia/Manila');

        $hour = $dateStr->gte($now) ? '05' : $now->format('H');

        if($now->format('i') <= 30){
            $mins = 30;
        } else {
            $hour++;
            $mins = 00;
        }

        $start = $hour . ':'. $mins;
        $end = '23:00';
        $duration = '30';

        $array_of_time = array();
        $start_time = strtotime($start);
        $end_time = strtotime($end);

        $add_mins = $duration * 60;

        while($start_time <= $end_time){

            $array_of_time[] = date("h:i a", $start_time);
            $start_time += $add_mins;

        }

        return $array_of_time;
    }

    public function refreshCalendar(){
        $events = Event::select('id','title','start')->get();
        $this->events = json_encode($events);        
    }

    protected $rules = [
        'title' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'description' => 'required'
    ];
}
