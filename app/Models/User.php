<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Course;
use App\Models\Progress;
use App\Models\Institution;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact_number',
        'institution_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function firstName(){
        $name = explode(' ', $this->name);
        return $name[0];
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function addCourse($data){
        return $this->courses()->create($data);
    }

    public function institution(){
        return $this->belongsTo(Institution::class);
    }

    public function instructorCourses(){
        return $this->belongsToMany(Course::class, 'course_instructor', 'instructor_id', 'course_id');
    }

    public function studentCourses(){
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('name', 'like', '%'.$search.'%');
    }

    public function progress(){
        return $this->hasMany(Progress::class, 'student_id');
    }

    public function addProgress($data){
        return $this->progress()->create($data);
    } 

    public function scopeStudentProgressCompleted($query){
        return $this->progress()->whereNotNull('completed_at')->get()->pluck('unit_id')->toArray();
    }  

    public function scopeGetCompletionTime($query, $unit_id){
        return $this->progress()
            ->where('unit_id', $unit_id)
            ->selectRaw('TIMESTAMPDIFF(minute, created_at, completed_at) as duration')
            ->first();
    }

}
