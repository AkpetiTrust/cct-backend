<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Course::create([
            "title" => "CCNA",
            "category" => "CISCO",
            "description" => "A CISCO course.It has also evolved to include a command-line interface capability and can be used in standalone graphical applications",
            "duration" => "3 months",
            "prerequisites_json" => json_encode([
                "Basic computer literacy",
                "Basic Microsoft Windows navigation skills",
                "Basic Internet usage skills",
                "Basic e-mail usage skills",
            ]),
            "advantages_json" => json_encode([
                "Basic computer literacy",
                "Basic Microsoft Windows navigation skills",
            ]),
            "course_outline" => json_encode([
                "Module 1: First module."
            ])
        ]);
        \App\Models\Course::create([
            "title" => "CCNP",
            "category" => "CISCO",
            "description" => "A CISCO course.It has also evolved to include a command-line interface capability and can be used in standalone graphical applications",
            "duration" => "3 months",
            "prerequisites_json" => json_encode([
                "Basic computer literacy",
                "Basic Microsoft Windows navigation skills",
                "Basic Internet usage skills",
                "Basic e-mail usage skills",
            ]),
            "advantages_json" => json_encode([
                "Basic computer literacy",
                "Basic Microsoft Windows navigation skills",
            ]),
            "course_outline" => json_encode([
                "Module 1: First module."
            ])
        ]);
        \App\Models\Course::create([
            "title" => "COMPTIA A+",
            "category" => "COMPTIA",
            "description" => "A CISCO course.It has also evolved to include a command-line interface capability and can be used in standalone graphical applications",
            "duration" => "3 months",
            "prerequisites_json" => json_encode([
                "Basic computer literacy",
                "Basic Microsoft Windows navigation skills",
                "Basic Internet usage skills",
                "Basic e-mail usage skills",
            ]),
            "advantages_json" => json_encode([
                "Basic computer literacy",
                "Basic Microsoft Windows navigation skills",
            ]),
            "course_outline" => json_encode([
                "Module 1: First module."
            ])
        ]);
        \App\Models\Course::create([
            "title" => "COMPTIA N+",
            "category" => "COMPTIA",
            "description" => "A CISCO course.It has also evolved to include a command-line interface capability and can be used in standalone graphical applications",
            "duration" => "3 months",
            "prerequisites_json" => json_encode([
                "Basic computer literacy",
                "Basic Microsoft Windows navigation skills",
                "Basic Internet usage skills",
                "Basic e-mail usage skills",
            ]),
            "advantages_json" => json_encode([
                "Basic computer literacy",
                "Basic Microsoft Windows navigation skills",
            ]),
            "course_outline" => json_encode([
                "Module 1: First module."
            ])
        ]);
    }
}
