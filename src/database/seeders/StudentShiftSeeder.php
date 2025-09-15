<?php

namespace Database\Seeders;

use App\Models\StudentShift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shifts = ['Shift A', 'Shift B', 'Shift C' ];

        foreach ($shifts as $shift) {
            StudentShift::create(['name' => $shift]);
        }
    }
}
