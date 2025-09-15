<?php

namespace Database\Seeders;

use App\Models\FeeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Registration fee', 'Montly fee', 'Exam fee'];

        foreach ($categories as $category) {
            FeeCategory::create(['name' => $category]);
        }
    }
}
