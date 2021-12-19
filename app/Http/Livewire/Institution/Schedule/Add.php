<?php

namespace App\Http\Livewire\Institution\Schedule;

use Firebase\JWT\JWT;
use App\Models\Course;
use Livewire\Component;
use App\Models\Institution;
use Illuminate\Support\Facades\Http;

class Add extends Component
{
    public $institution;
    public $courses;
    public $course_id;
    public $apiKey;
    public $apiSecret;
    public $zoomUrl;
    public $type;
    public $start_time;
    public $duration;
    public $duration_options;
    public $timezone;
    public $recurrence_type;
    public $recurrence_types;
    public $recurrence_interval;
    public $recurrence_day;
    public $recurrence_days;
    public $length;

    public function mount(Institution $institution){
        $this->institution  = $institution;
        $this->courses      = $this->institution->courses;
        $this->course_id    = 0;
        $this->apiKey       = $institution->zoom_api;
        $this->apiSecret    = $institution->zoom_secret;
        $this->zoomUrl      = 'https://api.zoom.us/v2/users/'.$institution->zoom_email.'/meetings';
        $this->type         = 8; //recurring meeting
        $this->start_time   = strtotime('2021-09-06T18:00:00');
        $this->timezone     = 'Asia/Singapore';
        $this->duration     = 180;
        $this->duration_options = [60, 120, 180, 240];
        $this->recurrence_interval = 1;
        $this->recurrence_type = 2;
        $this->recurrence_types = [
            1 => 'Daily',
            2 => 'Weekly',
            3 => 'Monthly'
        ];
        $this->recurrence_day = 2;
        $this->recurrence_days = [
            1 => 'Sunday',
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
            7 => 'Saturday'
        ];
        $this->length = 10;
    }

    public function render()
    {
        return view('livewire.institution.schedule.add');
    }

    public function addSchedule(){

        $this->validate();

        $course = $this->getCourse();

        $body = [
            'topic'      => $course->name,
            'type'       => $this->type,
            'start_time' => date("Y-m-d\TH:i:s", $this->start_time),
            'duration'   => $this->duration,
            'timezone'   => $this->timezone,
            'settings'   => [
                'host_video'        => false,
                'participant_video' => false,
                'join_before_host'  => false,
                'mute_upon_entry'   => true
            ],
            'recurrence' => [
                'type'  => $this->recurrence_type,
                'repeat_interval' => $this->recurrence_interval,
                'weekly_days' => $this->recurrence_day,
                'end_times' => $this->length
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->generateJWT(),
            'Content-Type' => 'application/json',
            'Accept'    => 'application/json'
        ])->post($this->zoomUrl, $body);

        $zoom_response = json_decode($response->getBody());

        $data = [
            'institution_id'    => $this->institution->id,
            'meeting_id'        => $zoom_response->id,
            'date'              => date("Y-m-d\TH:i:s", $this->start_time),
            'duration'          => $this->duration,
            'recurrence_type'   => $this->recurrence_type,
            'recurrence_interval' => $this->recurrence_interval,
            'recurrence_day'    => $this->recurrence_day,
            'course_length'     => $this->length,
            'start_url'         => $zoom_response->start_url,
            'join_url'          => $zoom_response->join_url
        ];

        $course->addSchedule($data);

        alert()->success("A new schedule has been created.", 'Congratulations!');

        return redirect()->to('/institutions/'.$this->institution->id);

    }

    public function getCourse(){
        return Course::find($this->course_id);
    }

    public function generateJWT(){
        
        $payload = array(
            "iss" => $this->apiKey,
            "exp" => strtotime('+1 minute')
        );

        return JWT::encode($payload, $this->apiSecret, 'HS256');
    }

    protected function messages(){
        return [
            'course_id.gt' => 'Please select a course'
        ];
    }

    protected function rules(){
        return [
            'course_id'     => 'required|gt:0',
            'duration'      => 'required',
            'recurrence_type'=> 'required',
            'recurrence_day'=> 'required',
            'recurrence_interval'=> 'required',
            'length'        => 'required'
        ];
    }

}
