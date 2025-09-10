<?php

namespace Database\Seeders;

use App\Models\ExamType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exams = ['1st terminal ', '2nd terminal', '4th terminal'];

        foreach ($exams as $exam) {
            ExamType::create(['name' => $exam]);
        }
    }
}
