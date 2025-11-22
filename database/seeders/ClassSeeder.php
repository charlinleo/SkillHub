<?php

namespace Database\Seeders;

use App\Models\SkillClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 'name'           => 'required|string|max:255',
            // 'description'    => 'nullable|string',
            // 'instructor_name'=> 'required|string|max:255',
            // 'start_date'     => 'nullable|date',
            // 'end_date'       => 'nullable|date|after_or_equal:start_date',
            // 'start_time'     => 'nullable|time',
            // 'end_time'       => 'nullable|time|after:start_time'

        SkillClass::updateOrCreate(
            ['name' => 'Desain Grafis'],
            [
                'description'    => '',
                'instructor_name'=> 'Pak Indra',
                'start_date'     => '2025-11-22',
                'end_date'       => '2025-11-25',
                'start_time'     => '07:00',
                'end_time'       => '19:00',
            ]
        );

    }
}
