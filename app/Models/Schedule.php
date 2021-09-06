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
        'meeting_id',
        'date',
        'duration',
        'recurrence_type',
        'recurrence_day',
        'recurrence_interval',
        'course_length',
    ];

    public function institution(){
        return $this->belongsTo(Institution::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
