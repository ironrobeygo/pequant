<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('institutions')->insert(
            ['name' => 'La Salle University']
        );

        DB::table('institutions')->insert(
            ['name' => 'Ateneo University']
        );

        DB::table('institutions')->insert(
            ['name' => 'Adamson University']
        );


    }
}
