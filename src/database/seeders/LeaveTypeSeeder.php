<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leaveTypes = [
            [
                'name' => 'Vacation',
                'code' => 'vacation',
                'description' => 'Paid rest days accumulated by the employee.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Sick Leave',
                'code' => 'sick',
                'description' => 'Absence due to health reasons (with or without a medical certificate).',
                'sort_order' => 2,
            ],
            [
                'name' => 'Maternity Leave',
                'code' => 'maternity',
                'description' => 'Paid leave for mothers before and after childbirth.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Paternity Leave',
                'code' => 'paternity',
                'description' => 'Paid leave for fathers following the birth of a child.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Bereavement Leave',
                'code' => 'bereavement',
                'description' => 'Days of absence due to the death of a close family member.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Personal Leave',
                'code' => 'personal',
                'description' => 'Absence for personal reasons not covered by other types.',
                'sort_order' => 6,
            ],
            [
                'name' => 'Unpaid Leave',
                'code' => 'unpaid',
                'description' => 'Authorized absence without pay.',
                'sort_order' => 7,
            ],
            [
                'name' => 'Study/Training Leave',
                'code' => 'study',
                'description' => 'Leave to attend courses, exams, or training sessions.',
                'sort_order' => 8,
            ],
            [
                'name' => 'Marriage Leave',
                'code' => 'marriage',
                'description' => 'Days of leave for the occasion of a wedding.',
                'sort_order' => 9,
            ],
            [
                'name' => 'Extended Medical Leave',
                'code' => 'medical',
                'description' => 'Prolonged absence due to medical treatment or surgery.',
                'sort_order' => 10,
            ],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::updateOrCreate(
                ['code' => $type['code']],
                $type
            );
        }
    }
}
