<?php

namespace Database\Seeders;

use App\Models\StudentClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = ['Class one', 'Class two', 'Class three', 'Class four', 'Class five'];

        foreach ($classes as $class) {
            StudentClass::create(['name' => $class]);
        }
    }
}
