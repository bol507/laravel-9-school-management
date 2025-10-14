<?php

namespace Database\Seeders;

use App\Models\LeaveStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'Pending',
                'code' => 'pending',
                'color' => 'yellow',
                'is_final' => false,
            ],
            [
                'name' => 'Approved',
                'code' => 'approved',
                'color' => 'green',
                'is_final' => true,
            ],
            [
                'name' => 'Rejected',
                'code' => 'rejected',
                'color' => 'red',
                'is_final' => true,
            ],
            [
                'name' => 'Cancelled',
                'code' => 'cancelled',
                'color' => 'gray',
                'is_final' => true,
            ],
        ];

        foreach ($statuses as $status) {
            LeaveStatus::updateOrCreate(
                ['code' => $status['code']],
                $status
            );
        }
    }
}
