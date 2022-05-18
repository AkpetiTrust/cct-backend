<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Student::create([
            'name' => Str::random(10),
            'email' => Str::random(10),
            'registration_number' => 'akpetitrust@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
