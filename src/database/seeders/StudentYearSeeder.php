<?php

namespace Database\Seeders;

use App\Models\StudentYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $years = ['2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025'];

        foreach ($years as $year) {
            StudentYear::create(['name' => $year]);
        }
    }
}
