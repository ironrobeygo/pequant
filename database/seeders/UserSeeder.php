<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Rob Go',
            'email' => 'mclordgt@gmail.com',
            'contact_number' => '09123456789',
            'institution_id' => 0,
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'mclordgt@gmail.com')->first();
        $user->assignRole('admin');

        $user = DB::table('users')->insert([
            'name' => 'Dondi San Jose',
            'email' => 'dondi.sanjose@gmail.com',
            'contact_number' => '09123456789',
            'institution_id' => 0,
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'dondi.sanjose@gmail.com')->first();
        $user->assignRole('admin');

        $user = DB::table('users')->insert([
            'name' => 'Vivienne Velasquez',
            'email' => 'vivienne@gmail.com',
            'contact_number' => '09123456789',
            'institution_id' => 0,
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'vivienne@gmail.com')->first();
        $user->assignRole('admin');

        $user = DB::table('users')->insert([
            'name' => 'Bea Magpayao',
            'email' => 'bea@gmail.com',
            'contact_number' => '09123456789',
            'institution_id' => 0,
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'bea@gmail.com')->first();
        $user->assignRole('admin');

        $user = DB::table('users')->insert([
            'name' => 'Samantha Burton',
            'email' => 'cuqe@mailinator.com',
            'contact_number' => '09123456789',
            'institution_id' => rand(1,3),
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'cuqe@mailinator.com')->first();
        $user->assignRole('instructor');

        $user = DB::table('users')->insert([
            'name' => 'Gisela Peck',
            'email' => 'towyvovi@mailinator.com',
            'contact_number' => '09123456789',
            'institution_id' => rand(1,3),
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'towyvovi@mailinator.com')->first();
        $user->assignRole('instructor');

        $user = DB::table('users')->insert([
            'name' => 'Drew Burns',
            'email' => 'zykyxys@mailinator.com',
            'contact_number' => '09123456789',
            'institution_id' => rand(1,3),
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'zykyxys@mailinator.com')->first();
        $user->assignRole('instructor');

        $user = DB::table('users')->insert([
            'name' => 'Dale Bush',
            'email' => 'dyzuxufo@mailinator.com',
            'contact_number' => '09123456789',
            'institution_id' => rand(1,3),
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'dyzuxufo@mailinator.com')->first();
        $user->assignRole('instructor');

        $user = DB::table('users')->insert([
            'name' => 'Darlene J. Soto',
            'email' => 'DarleneJSoto@teleworm.us',
            'contact_number' => '09123456789',
            'institution_id' => rand(1,3),
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'DarleneJSoto@teleworm.us')->first();
        $user->assignRole('student');

        $user = DB::table('users')->insert([
            'name' => 'Milton C. McKoy',
            'email' => 'MiltonCMcKoy@teleworm.us',
            'contact_number' => '09123456789',
            'institution_id' => rand(1,3),
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'MiltonCMcKoy@teleworm.us')->first();
        $user->assignRole('student');

        $user = DB::table('users')->insert([
            'name' => 'Deborah M. Price',
            'email' => 'DeborahMPrice@armyspy.com',
            'contact_number' => '09123456789',
            'institution_id' => rand(1,3),
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'DeborahMPrice@armyspy.com')->first();
        $user->assignRole('student');

        $user = DB::table('users')->insert([
            'name' => 'Matthew C. Miller',
            'email' => 'MatthewCMiller@rhyta.com',
            'contact_number' => '09123456789',
            'institution_id' => rand(1,3),
            'password' => Hash::make('!@#$%^&*'),
        ]);

        $user = User::where('email', 'MatthewCMiller@rhyta.com')->first();
        $user->assignRole('student');
    }
}
