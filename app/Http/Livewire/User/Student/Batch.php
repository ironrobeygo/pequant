<?php

namespace App\Http\Livewire\User\Student;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Institution;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
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

        DB::beginTransaction();

        try{

            SimpleExcelReader::create($basePath, 'csv')
                ->getRows()
                ->each(
                    function(array $data){

                        $institution_id = Institution::where('name', $data['institution'])->first()->id;

                        $user = User::create([
                            'name'              => $data['name'] . ' ' . $data['last_name'],
                            'email'             => $data['email'],
                            'contact_number'    => $data['contact_number'],
                            'password'          => Hash::make('!@#$%^&*'),
                            'institution_id'    => $institution_id
                        ]);

                        $user->assignRole($data['role']);

                        $course = Course::where('name', $data['course'])->first();
                        $course->enrolStudent($user->id);

                        DB::commit();
                    }
                );

            alert()->success("Batch upload successful.", 'Congratulations!');

        } catch(QueryException $e){

            DB::rollback();

            alert()->error('An error has occurred, please double check your input file', 'Please try again!');

        }

        return redirect()->to('/students');
        
    }
}
