<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use App\Models\StudentYear;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Http\Request;
use stdClass;

class StudentPromotionController extends Controller
{
    private StudentRepositoryInterface $repository;

    public function __construct(StudentRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id) {
        $docs = new stdClass();
        $docs->years = StudentYear::all();
        $docs->classes = StudentClass::all();
        $docs->groups = StudentGroup::all();
        $docs->shifts = StudentShift::all();
        $docs->genderOptions = Profile::genderOptions();
        $docs->student = $this->repository->findDTOOrFail($id);
        return view('backend.student.registration.promotion-registration',['docs' => $docs]);
    }


    public function update(Request $request, $id)
    {
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


    public function destroy($id)
    {
        //
    }
}
