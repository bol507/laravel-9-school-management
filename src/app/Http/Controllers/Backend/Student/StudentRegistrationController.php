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

    public function EditStudentPromotion($id){
        $docs = new stdClass();
        $docs->years = StudentYear::all();
        $docs->classes = StudentClass::all();
        $docs->groups = StudentGroup::all();
        $docs->shifts = StudentShift::all();
        $docs->genderOptions = Profile::genderOptions();
        $docs->student = AssignStudent::with(['user','discount','profile'])->where('id',$id)
            ->first();
        return view('backend.student.registration.promotion-registration',['docs' => $docs]);
    }

    public function UpdateStudentPromotion(UpdateStudentRegistrationRequest $request, $id){
        try{
            $validated = $request->validated();

            if ($request->hasFile('image')) {
                $imageUploadService = new ImgBbUploaderService();
                $validated['image'] = $imageUploadService->upload($request->file('image'));
            }

            $category = FeeCategory::ensureRegistrationFeeExists();
            $validated['fee_category_id'] = $category->id;
            $student = AssignStudent::findOrFail($id);
            if (!$student) {
                throw new Exception('Student promotion not found.');
            }

            $registration = DB::transaction(function () use ($validated, $student) {


                $user = User::updateOrCreate(
                    ['id' => $student->student_id],//match
                    ['name' => $validated['name']]
                );

                $profileStudentFactory = new ProfileStudentFactory();
                $profileStudentFactory->updateOrCreate($user->id, $validated);

                DiscountStudent::updateOrCreate(
                    ['assign_student_id' => $user->id],
                    [
                        'fee_category_id' => $validated['fee_category_id'],
                        'discount' => $validated['discount']
                    ]
                );

                return AssignStudent::updateOrCreate(
                    ['student_id' => $user->id], //match
                    [
                        'year_id' => $validated['year_id'],
                        'class_id' => $validated['class_id'],
                        'group_id' => $validated['group_id'],
                        'shift_id' => $validated['shift_id'],
                    ]
                );
            });

            $notification = $this->createNotification($registration);
            return redirect()
                ->route('student.registration.view')
                ->with($notification);
        } catch (Exception $e) {

            Log::error('An error occurred while processing the request:',[
                'message' =>  $e->getMessage(),
                'request' => $request->except(['image'], true)
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'message' => 'An error occurred while saving the promotion: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }

    public function show($id){
        $student = AssignStudent::findOrFail($id);
        return PDF::loadView('pdfs.student', [
        'user' => $student->user,
        'year' => $student->year,
        'class' => $student->class,
        'profile' => $student->profile,
        ])->stream("student_{$student->id}.pdf");
    }

    private function createNotification($value){
        if ($value->wasRecentlyCreated) {
            return [
                'message' => 'Assignation created successfully',
                'alert-type' => 'success'
            ];
        } else {
            return [
                'message' => 'Assignation updated successfully',
                'alert-type' => 'warning'
            ];
        }
    }


}
