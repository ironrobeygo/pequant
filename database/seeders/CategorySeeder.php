<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            ['name' => 'Business Analytics', 'description' => 'Category Description here']
        );

        DB::table('categories')->insert(
            ['name' => 'Data Science', 'description' => 'Category Description here']
        );
        
    }
}
