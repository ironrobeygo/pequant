<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'zoom_email',
        'zoom_api',
        'zoom_secret'
    ];

    public function path(){
        return "/api/institutions/{$this->id}";
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function students(){
        return $this->hasMany(User::class)->role('student');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('name', 'like', '%'.$search.'%');
    }

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
