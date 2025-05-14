<?php

namespace Database\Seeders;

use App\Models\MarkSetup;
use Illuminate\Database\Seeder;

class MarkSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MarkSetup::create([
            'ca1' => 20,
            'ca2' => 20,
            'exam' => 60,
            'total' => 100,
        ]);
    }
}
