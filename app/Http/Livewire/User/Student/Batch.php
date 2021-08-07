<?php

namespace App\Http\Livewire\User\Student;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Spatie\SimpleExcel\SimpleExcelReader;

class Batch extends Component
{
    use WithFileUploads;

    public $batch_upload;

    public function render()
    {
        return view('livewire.user.student.batch');
    }

    public function batchUser(){

        $basePath = $this->batch_upload->getRealPath();

        SimpleExcelReader::create($basePath, 'csv')
            ->getRows()
            ->each(
                function(array $data){

                    $user = User::create([
                        'name'              => $data['name'] . ' ' . $data['last_name'],
                        'email'             => $data['email'],
                        'contact_number'    => $data['contact_number'],
                        'password'          => Hash::make('!@#$%^&*'),
                        'institution_id'    => $data['institution_id']
                    ]);

                    $user->assignRole($data['role']);

                    $course = Course::where('id', $data['course_id'])->first();
                    $course->enrolStudent($user->id);

                }
            );

        alert()->success('Batch Upload Successful', 'Congratulations!');

        return redirect()->to('/students');
    }
}
