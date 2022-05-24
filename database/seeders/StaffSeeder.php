<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Staff::create([
            'name' => Str::random(10),
            'email' => Str::random(10),
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    
        \App\Models\Staff::create([
            'name' => Str::random(10),
            'email' => Str::random(10),
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
