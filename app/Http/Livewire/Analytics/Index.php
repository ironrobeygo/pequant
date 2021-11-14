<?php

namespace App\Http\Livewire\Analytics;

use DB;
use App\Models\User;
use Livewire\Component;
use App\Models\Activity;
use App\Models\Institution;

class Index extends Component
{

    public $filter;
    public $range;
    public $institutions;
    public $sections;
    public $section;
    public $ticks;

    protected $listeners = ['resetChart' => 'render'];

    public function mount(){
        $this->filter   = 0;
        $this->range    = 'month';
        $this->institutions = Institution::all();
        foreach($this->institutions as $institution){
            $this->sections[$institution->id] = array_filter(User::where('institution_id', $institution->id)->select('section')->groupBy('section')->get()->pluck('section')->toArray());
        }

    }

    public function render()
    {

        $data = array();

        foreach($this->institutions as $institution){

            $tick_data = array();

            $data[$institution->id]['label'] = $institution->name;

            $ticks = Activity::whereHas('user', function($q) use ($institution){
                        $q->where('institution_id', $institution->id);
                    })
                    ->where('event', 'has successfully logged in')
                    ->select(
                            DB::raw("(count(id)) as total"),
                            DB::raw("(DATE_FORMAT(created_at, '%m-%Y')) as month_year"))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
                        ->orderBy('month_year', 'ASC')
                        ->get()->values()->toArray();

            $counter = 0;

            foreach($ticks as $tick){

                $tick_data[$counter]['id'] = $tick['month_year'];
                $tick_data[$counter]['nested'] = array('value' => $tick['total']);  

                $counter++;
            }

            $data[$institution->id]['data'] = $tick_data;
            $color = $this->colorGenerate();
            $data[$institution->id]['borderColor'] = $color;
            $data[$institution->id]['backgroundColor'] = $color;

        }

        $this->ticks = json_encode(array_values($data));

        return view('livewire.analytics.index');
    }

    public function updateFilter(){

        $filterchecker = (int)$this->filter > 0;
        $filter = (int)$this->filter;
        $data = [];

        $date_format = $this->range == 'month' ? '%m-%Y' : '%Y'; 

        if($filterchecker){

            foreach($this->sections[$this->filter] as $section){

                $tick_data = array();

                $data[$section]['label'] = $section;

                $ticks = Activity::whereHas('user', function($q) use ($section){
                            $q->where('section', $section);
                        })
                        ->where('event', 'has successfully logged in')
                        ->select(
                                DB::raw("(count(id)) as total"),
                                DB::raw("(DATE_FORMAT(created_at, '{$date_format}')) as month_year"))
                            ->groupBy(DB::raw("DATE_FORMAT(created_at, '{$date_format}')"))
                            ->orderBy('month_year', 'ASC')
                            ->get()->values()->toArray();

                $counter = 0;

                foreach($ticks as $tick){

                    $tick_data[$counter]['id'] = $tick['month_year'];
                    $tick_data[$counter]['nested'] = array('value' => $tick['total']);  

                    $counter++;
                }

                $data[$section]['data'] = $tick_data;
                $color = $this->colorGenerate();
                $data[$section]['borderColor'] = $color;
                $data[$section]['backgroundColor'] = $color;
            }

        }

        $this->ticks = json_encode(array_values($data));

        $this->emit('updatedFilter', $this->ticks);
    }

    public function updateSection(){
        $filterchecker = (int)$this->section != '';
        $section = $this->section;
        $data = [];

        $date_format = $this->range == 'month' ? '%m-%Y' : '%Y'; 

        $tick_data = array();

        $data[$section]['label'] = 'Section ' . $section;

        $ticks = Activity::whereHas('user', function($q) use ($section){
                    $q->where('section', $section);
                })
                ->where('event', 'has successfully logged in')
                ->select(
                        DB::raw("(count(id)) as total"),
                        DB::raw("(DATE_FORMAT(created_at, '{$date_format}')) as month_year"))
                    ->groupBy(DB::raw("DATE_FORMAT(created_at, '{$date_format}')"))
                    ->orderBy('month_year', 'ASC')
                    ->get()->values()->toArray();

        $counter = 0;

        foreach($ticks as $tick){

            $tick_data[$counter]['id'] = $tick['month_year'];
            $tick_data[$counter]['nested'] = array('value' => $tick['total']);  

            $counter++;
        }

        $data[$section]['data'] = $tick_data;
        $color = $this->colorGenerate();
        $data[$section]['borderColor'] = $color;
        $data[$section]['backgroundColor'] = $color;

        $this->ticks = json_encode(array_values($data));

        $this->emit('updatedSection', $this->ticks);
    }

    public function resetChart(){

        $this->filter = 0;
        $this->range = 'month';

        $data = array();

        foreach($this->institutions as $institution){

            $tick_data = array();

            $data[$institution->id]['label'] = $institution->name;

            $ticks = Activity::whereHas('user', function($q) use ($institution){
                        $q->where('institution_id', $institution->id);
                    })
                    ->where('event', 'has successfully logged in')
                    ->select(
                            DB::raw("(count(id)) as total"),
                            DB::raw("(DATE_FORMAT(created_at, '%m-%Y')) as month_year"))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
                        ->orderBy('month_year', 'ASC')
                        ->get()->values()->toArray();

            $counter = 0;

            foreach($ticks as $tick){

                $tick_data[$counter]['id'] = $tick['month_year'];
                $tick_data[$counter]['nested'] = array('value' => $tick['total']);  

                $counter++;
            }

            $data[$institution->id]['data'] = $tick_data;
            $color = $this->colorGenerate();
            $data[$institution->id]['borderColor'] = $color;
            $data[$institution->id]['backgroundColor'] = $color;

        }

        $this->ticks = json_encode(array_values($data));

        $this->emit('resetChart', $this->ticks);
    }

    public function colorGenerate(){
        return '#' . dechex(rand(0x000000, 0xFFFFFF));
    }
}
