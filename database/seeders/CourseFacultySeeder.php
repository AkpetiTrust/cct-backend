<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourseFacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Course::find(1)->faculties()->attach([1,2]);
    }
}
