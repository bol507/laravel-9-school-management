<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\StudentShift;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Admin User',
             'email' => 'admin@demo.com',
             'password' => bcrypt('12345678'),
             'user_type' => 'Admin',
         ]);
        $this->call([
           // ProfileSeeder::class,
            StudentClassSeeder::class,
            StudentYearSeeder::class,
            StudentGroupSeeder::class,
            StudentShiftSeeder::class,
            ExamTypeSeeder::class,
            FeeCategorySeeder::class,
            DesignationSeeder::class,
            LeaveTypeSeeder::class,
            LeaveStatusSeeder::class,
        ]);
    }
}
