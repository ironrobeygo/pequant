<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use App\Models\Announcement;

class Student extends Component
{
    public $announcements;
    public $user;
    public $progress;
    public $scores;

    public function mount(){
        $this->user = auth()->user();
        $this->progress = $this->user->progress;
        $this->scores = $this->user->scores()->orderBy('created_at', 'desc')->get();

        $admin_ids = User::with('roles')->whereHas('roles', function($query){
                $query->whereIn("name", ['admin']);
            })
            ->get()
            ->pluck('id')
            ->values()
            ->toArray();

        $instructor_ids = User::with('roles')
            ->whereHas('roles', function($query){
                $query->whereIn("name", ['instructor']);
            })
            ->where('institution_id', $this->user->institution_id)
            ->get()
            ->pluck('id')
            ->values()
            ->toArray();

        $include_ids = array_merge($admin_ids, $instructor_ids);

        $this->announcements = Announcement::where('status', 1)->whereIn('user_id', $include_ids)->latest()->take(5)->get();

    }

    public function render()
    {
        return view('livewire.dashboard.student');
    }
}
