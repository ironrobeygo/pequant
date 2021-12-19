<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Institution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'institution_id',
        'meeting_id',
        'date',
        'duration',
        'recurrence_type',
        'recurrence_day',
        'recurrence_interval',
        'course_length',
        'start_url',
        'join_url'
    ];

    public function institution(){
        return $this->belongsTo(Institution::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function showRecurrenceType(){
        switch($this->recurrence_type){
            default:
                $type = 'Daily';
            break;

            case 2: 
                $type = 'Weekly';
            break;

            case 3:
                $type = 'Monthly';
            break;
        }

        return $type;
    }
}
