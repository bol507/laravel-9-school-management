<?php

namespace App\Http\Controllers\Backend\Student;

use App\DTO\StudentDTO;
use App\Facades\PDF;
use App\Factories\ProfileStudentFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRegistrationRequest;
use App\Http\Requests\UpdateStudentRegistrationRequest;
use App\Models\AssignStudent;
use App\Models\DiscountStudent;
use App\Models\FeeCategory;
use App\Models\Profile;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use App\Models\StudentYear;
use App\Models\User;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Services\Contracts\StudentCreatorServiceInterface;
use App\Services\Contracts\StudentUpdaterServiceInterface;
use App\Services\ImgBbUploaderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;
use Throwable;

class StudentRegistrationController extends Controller
{
    private StudentRepositoryInterface $repository;
    private StudentCreatorServiceInterface $creatorService;
    private StudentUpdaterServiceInterface $updaterService;

    public function __construct(
        StudentRepositoryInterface $repository,
        StudentCreatorServiceInterface $creatorService,
        StudentUpdaterServiceInterface $updaterService,
    ){
        $this->repository = $repository;
        $this->creatorService = $creatorService;
        $this->updaterService = $updaterService;
    }

    public function index(Request $request) {
        $perPage = (int) $request->input('limit',10);
        $perPage = max(1,min($perPage,100));
        $search = $request->input('search');

        $students = $this->repository->paginate(
            perPage: $perPage,
            search: $search,
        );

        $docs = (object)[
            'students'    => $students,
            'search'      => $request->input('search'),
            'years'       => StudentYear::all()->sortByDesc('name')->values(),
            'classes'     => StudentClass::all()->sortByDesc('name')->values(),
        ];

        return view('backend.student.registration.view-registration',compact('docs'));
    }

    public function create  (){
        $docs = new stdClass();
        $docs->years = StudentYear::all();
        $docs->classes = StudentClass::all();
        $docs->groups = StudentGroup::all();
        $docs->shifts = StudentShift::all();
        $docs->genderOptions = Profile::genderOptions();
        return view('backend.student.registration.add-registration',['docs' => $docs]);
    }

    public function store(StoreStudentRegistrationRequest $request){

        try{
            $dto = new StudentDTO($request->validatedForDto());
            $image = $request->file('image');
            $this->creatorService->execute($dto, $image);
            return redirect()
                ->route('student.registration.view')
                ->with([
                    'message' => 'Student registered successfully',
                    'alert-type' => 'success'
                ]);
        } catch (Throwable $e) {

            Log::error('Student registration failed',[
                'message' =>  $e->getMessage(),
                'line'    => $e->getLine(),
                'stack' => $e->getTraceAsString(),
                'request_data' => $request->except(['image','_token']),
            ]);
            return redirect()
                ->back()
                ->withInput($request->except(['image']))
                ->withErrors([
                    'message' => 'An error occurred while saving the student. Please try again',
                    'alert-type' => 'error'
                ]);
        }

    }

    public function edit($id){
        $docs = new stdClass();
        $docs->years = StudentYear::all();
        $docs->classes = StudentClass::all();
        $docs->groups = StudentGroup::all();
        $docs->shifts = StudentShift::all();
        $docs->genderOptions = Profile::genderOptions();
        $docs->student = $this->repository->findDTOOrFail($id);
        return view('backend.student.registration.edit-registration',['docs' => $docs]);
    }

    public function update(UpdateStudentRegistrationRequest $request, $id){
        try{
            $dto = new StudentDTO($request->validatedForDto());
            $image = $request->file('image');
            $this->updaterService->execute($id,$dto,$image);


            return redirect()
                ->route('student.registration.view')
                ->with([
                    'message' => 'Student updated successfully',
                    'alert-type' => 'success'
                ]);
        } catch (Exception $e) {

            Log::error('Student updating failed',[
                'message' =>  $e->getMessage(),
                'line'    => $e->getLine(),
                'stack' => $e->getTraceAsString(),
                'request_data' => $request->except(['image','_token']),
            ]);
            return redirect()
                ->back()
                ->withInput($request->except(['image']))
                ->withErrors([
                    'message' => 'An error occurred while saving the assignation. Pleaser try again ',
                    'alert-type' => 'error'
                ]);
        }
    }

    public function UpdateStudentPromotion(UpdateStudentRegistrationRequest $request, $id){

    }

    public function show($id){
        $studentDTO = $this->repository->findDTOOrFail($id);
        
        $year = $studentDTO->yearId ? StudentYear::find($studentDTO->yearId) : null;
        $class = $studentDTO->classId ? StudentClass::find($studentDTO->classId) : null;
        $group = $studentDTO->groupId ? StudentGroup::find($studentDTO->groupId) : null;
        $shift = $studentDTO->shiftId ? StudentShift::find($studentDTO->shiftId) : null;

        $docs = new stdClass();
        $docs->student = (object) array_merge(
            get_object_vars($studentDTO),
            [
                'yearName' => $year?->name,
                'className' => $class?->name,
                'groupName' => $group?->name,
                'shiftName' => $shift?->name,
            ]
        );

        return view('backend.student.registration.details',['docs' => $docs]);
    }

    public function pdf($id){
        $student = AssignStudent::findOrFail($id);
        return PDF::loadView('pdfs.student', [
        'user' => $student->user,
        'year' => $student->year,
        'class' => $student->class,
        'profile' => $student->profile,
        ])->stream("student_{$student->id}.pdf");
    }
}
