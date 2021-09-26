<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\Unit;
use App\Models\Score;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Progress;
use App\Models\Institution;
use App\Models\Announcement;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use InteractsWithMedia;

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
        'section',
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
        return $this->hasMany(Course::class, 'instructor_id');
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

    public function scopeStudentRecentProgress(){

        return $this->progress()->orderBy('updated_at', 'desc')->get();

    }

    public function scopeStudentProgress($query, $course_id){

        $total_units    = 0;
        $chapters = $this->studentCourses()
            ->where('course_id', $course_id)
            ->first()
            ->chapters;

        foreach($chapters as $chapter){
            $total_units += $chapter->units->count();
            $total_units += $chapter->quizzes->count();
        }

        $completed = $this->progress->filter(function($value, $key){
            return $value->isCompleted();
        })->count();

        if( $completed == 0 || $total_units == 0 ){
            return 0;
        }

        return number_format($completed/$total_units*100, 2);
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

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function addAnswer($data){
        return $this->answers()->create($data);
    }

    public function scores(){
        return $this->hasMany(Score::class);
    }

    public function addScore($data){
        return $this->scores()->create($data);
    }

    public function scopeGetQuizScore($query, $quiz_id){
        $score = $this->scores()->where('quiz_id', $quiz_id)->first();

        if(!$score){
            return false;
        }

        return $score;

    }

    public function scopeGetQuizAnswers($query, $quiz_id){

        $collections = $this->answers()
            ->where('quiz_id', $quiz_id)
            ->get()
            ->map(function($item, $key){

                $data[$item->question_id] = array(
                    'answer_id' => $item->id,
                    'answer'    => $item->answer,
                    'point'     => $item->point
                );

                return $data;
            });

        $return = array();

        foreach($collections as $collection){
            foreach($collection as $key => $coll){
                $return[$key] = $coll;
            }
        }

        return $return;
    }

    public function announcements(){
        return $this->hasMany(Announcement::class);
    }

    public function addAnnouncement($data){
        return $this->announcements()->create($data);
    }
}
