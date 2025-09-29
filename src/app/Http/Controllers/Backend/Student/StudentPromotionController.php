<?php

namespace App\Http\Controllers\Backend\Student;

use App\DTO\StudentDTO;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use App\Models\StudentYear;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Services\Contracts\StudentUpdaterServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;
use Throwable;

class StudentPromotionController extends Controller
{
    private StudentRepositoryInterface $repository;
    private StudentUpdaterServiceInterface $updaterService;

    public function __construct(
        StudentRepositoryInterface $repository,
        StudentUpdaterServiceInterface $updaterService,
    ){
        $this->repository = $repository;
        $this->updaterService = $updaterService;
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
            $dto = new StudentDTO($request->validatedForDTO());
            $image = $request->file('iamge');
            $this->updaterService->execute($id,$dto, $image);
            return redirect()
                ->route('student.registration.view')
                ->with([
                    'message' => 'Student promotioned succesfully',
                    'alert-type' => 'success'
                ]);
        } catch (Throwable $e) {

            Log::error('An error occurred while processing the request:',[
                'message' =>  $e->getMessage(),
                'request' => $request->except(['image'], true)
            ]);
            return redirect()
                ->back()
                ->withInput($request->except(['image']))
                ->withErrors([
                    'message' => 'An error occurred while saving the promotion: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }

}
