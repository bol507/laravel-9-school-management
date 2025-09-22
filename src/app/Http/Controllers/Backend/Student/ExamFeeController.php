<?php

namespace App\Http\Controllers\Backend\Student;

use App\Facades\PDF;
use App\Http\Controllers\Concerns\Listable;
use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\ExamType;
use App\Models\StudentClass;
use App\Models\StudentYear;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ExamFeeController extends Controller
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

    protected function listableQueryScope(Builder $query, Request $request): Builder
    {
        return $query->whereHas('user', fn ($q) => $q->where('user_type', 'student'));
    }

    public function ViewExamFee(Request $request){
        if (!$request->filled(['year_id','class_id'])) {
            $empty = new LengthAwarePaginator(
                collect(), 0, 10, $request->input('page',1),
                ['path'=>$request->url()]
            );
            $students = $empty;
        } else {
            $students = $this->list($request);  
        }
        $docs = (object) [
            'students' => $students,
            'search' => $request->input('search'),
            'years'    => StudentYear::all()->sortByDesc('name')->values(),
            'classes'  => StudentClass::all()->sortByDesc('name')->values(),
            'exam_types' => ExamType::all()->sortByDesc('name')->values(),
        ];
        return view('backend.student.exam_fee.view-registration', compact('docs'));
    }

    public function PayslipExamFee(Request $request){
        $data = $request->validate([
            'student_id' => ['required','string'],
            'class_id'   => ['required','string'],
            'exam_id' => ['required','string']
        ]);

        $studentId = $data['student_id'];
        $classId   = $data['class_id'];
        $examId = $data['exam_id'];

        $details = AssignStudent::with(['user','profile','discounts'])
            ->where('student_id', $studentId)
            ->where('class_id',   $classId)
            ->firstOrFail();

        $slugSource = $details->profile->student_no ?? $details->user->name ?? (string) $details->student_id;
        $fileName = 'student_' . Str::slug($slugSource) . '.pdf';

        $exam_name = ExamType::findOrFail($examId)->value('name');


        $docs = (object)[
            'details' => $details,
            'exam_name' => $exam_name
        ];

        return PDF::loadView('pdfs.student-details', [
            'docs' => $docs,
        ])->stream($fileName);
    }

}
