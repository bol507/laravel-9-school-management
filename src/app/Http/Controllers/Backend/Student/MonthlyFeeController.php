<?php

namespace App\Http\Controllers\Backend\Student;

use App\Facades\PDF;
use App\Http\Controllers\Concerns\Listable;
use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\StudentClass;
use App\Models\StudentYear;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MonthlyFeeController extends Controller
{
    use Listable;

    protected function listableModel(): string {
        return AssignStudent::class;
    }

    protected function listableWith(): array {
        return ['user', 'profile'];
    }

    protected function listableSearchColumns(): array {
        return ['user.name'];   // relationship.column
    }

    protected function listableFilters(): array{
        return ['year_id', 'class_id'];
    }

    public function ViewMonthlyFee (Request $request){
        $students = $this->list($request);
        $months = $this->getMonths();
        $docs = (object)[
            'students' => $students,
            'search'   => $request->input('search'),
            'years'    => StudentYear::all()->sortByDesc('name')->values(),
            'classes'  => StudentClass::all()->sortByDesc('name')->values(),
            'months' => $months
        ];
        return view('backend.student.monthly_fee.view-registration', compact('docs'));
    }

    public function PayslipMonthlyFee(Request $request){
        $data = $request->validate([
            'student_id' => ['required','string'],
            'class_id'   => ['required','string'],
            'month_id' => ['required','numeric']
        ]);

        $studentId = $data['student_id'];
        $classId   = $data['class_id'];
        $monthId = $data['month_id'];

         $details = AssignStudent::with(['user','profile','discounts'])
            ->where('student_id', $studentId)
            ->where('class_id',   $classId)
            ->firstOrFail();
        $months = $this->getMonths();
        $monthName = $months[$monthId] ?? 'Unknown Month';
        $slugSource = $details->profile->student_no ?? $details->user->name ?? (string) $details->student_id;
        $fileName = 'student_' . Str::slug($slugSource) . '.pdf';

        $docs = (object)[
            'details' => $details,
            'month_name' => $monthName,
        ];

        return PDF::loadView('pdfs.student-details', [
            'docs' => $docs,
        ])->stream($fileName);
    }

    private function getMonths() {
    return [
        (object)['id' => 1, 'name' => 'January'],
        (object)['id' => 2, 'name' => 'February'],
        (object)['id' => 3, 'name' => 'March'],
        (object)['id' => 4, 'name' => 'April'],
        (object)['id' => 5, 'name' => 'May'],
        (object)['id' => 6, 'name' => 'June'],
        (object)['id' => 7, 'name' => 'July'],
        (object)['id' => 8, 'name' => 'August'],
        (object)['id' => 9, 'name' => 'September'],
        (object)['id' => 10, 'name' => 'October'],
        (object)['id' => 11, 'name' => 'November'],
        (object)['id' => 12, 'name' => 'December'],
    ];
}
}
