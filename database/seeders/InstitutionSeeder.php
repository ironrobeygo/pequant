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
            ['name' => 'La Salle University', 'alias' => 'La Salle']
        );

        DB::table('institutions')->insert(
            ['name' => 'Ateneo University', 'alias' => 'Ateneo']
        );

        DB::table('institutions')->insert(
            ['name' => 'Adamson University', 'alias' => 'Adamson']
        );

        DB::table('institutions')->insert(
            ['name' => 'University of Sto. Thomas', 'alias' => 'UST']
        );

    }
}
