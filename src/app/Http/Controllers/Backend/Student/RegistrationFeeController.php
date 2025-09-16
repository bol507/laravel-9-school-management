<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Concerns\Listable;
use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\FeeCategory;
use App\Models\FeeCategoryAmount;
use App\Models\StudentClass;
use App\Models\StudentYear;
use Illuminate\Http\Request;

class RegistrationFeeController extends Controller
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

    
    public function ViewRegistrationFee(Request $request){
        $students = $this->list($request);

        $docs = (object)[
            'students' => $students,
            'search'   => $request->input('search'),
            'years'    => StudentYear::all()->sortByDesc('name')->values(),
            'classes'  => StudentClass::all()->sortByDesc('name')->values(),
        ];
        return view('backend.student.registration_fee.view-registration', compact('docs'));
    }



}
