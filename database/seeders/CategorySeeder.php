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
            ['name' => 'Data Analytics', 'description' => 'Category Description here']
        );

        DB::table('categories')->insert(
            ['name' => 'Data Science', 'description' => 'Category Description here']
        );

        DB::table('categories')->insert(
            ['name' => 'Data Warehousing', 'description' => 'Category Description here']
        );

        DB::table('categories')->insert(
            ['name' => 'Fundamentals of Business Analytics', 'description' => 'Category Description here']
        );

        DB::table('categories')->insert(
            ['name' => 'Professional Certificate Courses', 'description' => 'Category Description here']
        );

        
    }
}
