<?php

namespace Database\Seeders;

use App\Models\FeeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeeCategorySeeder extends Seeder
{
    
    public function run()
    {
        $categories = ['Registration fee', 'Monthly fee', 'Exam fee'];

        FeeCategory::ensureDefaultFeesExist($categories);
    }
}
