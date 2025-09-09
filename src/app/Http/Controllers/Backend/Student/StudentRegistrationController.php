<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\Profile;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use App\Models\StudentYear;
use Illuminate\Http\Request;
use stdClass;

class StudentRegistrationController extends Controller
{
    public function ViewStudentRegistration(Request $request) {
        $perPage = (int) $request->input('limit',10);
        $perPage = max(1,min($perPage,100));

        $search = trim((string) $request->input('search','') );
        $query = AssignStudent::with('user');

        if($search){
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $docs = $query
            ->orderBy('student_id')
            ->paginate()
            ->appends($request->query());
        return view('backend.student.registration.view-registration',compact('docs','search'));

    }

    public function AddStudentRegistration(){
        $docs = new stdClass();
        $docs->year = StudentYear::all();
        $docs->classes = StudentClass::all();
        $docs->groups = StudentGroup::all();
        $docs->shifts = StudentShift::all();
        $docs->genderOptions = Profile::genderOptions();
        return view('backend.student.registration.add-registration',['docs' => $docs]);
    }
}
