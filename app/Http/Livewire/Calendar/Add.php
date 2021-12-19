<?php

namespace App\Http\Livewire\Calendar;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Course;
use Livewire\Component;
use App\Notifications\EventCreated;
use Illuminate\Support\Facades\Notification;

class Add extends Component
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

        // $this->selectedDate = request()->date;
        $dateStr = Carbon::parse(request()->date);
        $this->selectedDate['dateStr'] = $dateStr->format('l, F j, Y');
        $start_time = $end_time = $this->timeInterval($dateStr);
        
        array_pop($start_time);        
        $this->selectedDate['start_time'] = $start_time;
        array_shift($end_time);
        $this->selectedDate['end_time'] = $end_time;
    }

    public function render()
    {
        return view('livewire.calendar.add');
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

        $course = Course::find($this->course_id);

        $students = $course->students;

        $data['event_title'] = $this->title;
        $data['event_link'] = $this->event_link;
        $data['event_date'] = $this->selectedDate['dateStr'];
        $data['event_time'] = $this->start_time .' - '.$this->end_time;
        $data['course'] = $course->name;

        foreach($students as $student){

            $data['name'] = $student->name;

            Notification::send($student, new EventCreated($data));
        }

        return redirect()->to('/events');

        
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

    protected $rules = [
        'title' => 'required',
        'course_id' => 'required|gt:0',
        'start_time' => 'required',
        'end_time' => 'required'
    ];
}
