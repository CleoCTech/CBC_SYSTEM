<?php

namespace Database\Seeders;

use App\Models\GradingSystem;
use Illuminate\Database\Seeder;

class GradingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gradingSystems = [
            ['grade' => 'A', 'min_points' => 80, 'max_points' => 100, 'remark' => 'Excellent'],
            ['grade' => 'B', 'min_points' => 70, 'max_points' => 79, 'remark' => 'Very Good'],
            ['grade' => 'C', 'min_points' => 60, 'max_points' => 69, 'remark' => 'Good'],
            ['grade' => 'D', 'min_points' => 50, 'max_points' => 59, 'remark' => 'Fair'],
            ['grade' => 'E', 'min_points' => 40, 'max_points' => 49, 'remark' => 'Pass'],
            ['grade' => 'F', 'min_points' => 0, 'max_points' => 39, 'remark' => 'Fail'],
        ];

        foreach ($gradingSystems as $gradingSystem) {
            GradingSystem::create($gradingSystem);
        }
    }
}
