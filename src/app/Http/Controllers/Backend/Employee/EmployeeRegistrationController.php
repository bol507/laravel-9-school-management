<?php

namespace App\Http\Controllers\Backend\Employee;

use App\DTO\EmployeeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRegistrationRequest;
use App\Http\Requests\UpdateEmployeeRegistrationRequest;
use App\Models\Designation;
use App\Models\Profile;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Contracts\EmployeeCreatorServiceInterface;
use App\Services\Contracts\EmployeeUpdaterServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;
use Throwable;

class EmployeeRegistrationController extends Controller
{


    private EmployeeUpdaterServiceInterface $updaterService;
    private EmployeeCreatorServiceInterface $creatorService;
    private EmployeeRepositoryInterface $repository;

    public function __construct(
        EmployeeUpdaterServiceInterface $updaterService,
        EmployeeCreatorServiceInterface $creatorService,
        EmployeeRepositoryInterface $repository
    ) {
        $this->updaterService = $updaterService;
        $this->creatorService = $creatorService;
        $this->repository = $repository;
    }



    public function index(Request $request){

        $perPage = (int) $request->input('limit',10);
        $perPage = max(1,min($perPage,100));
        $search = $request->input('search');

        $employees = $this->repository->paginate(
            perPage: $perPage,
            search: $search,
        );

        $docs = (object) [
            'employees' => $employees,
            'search' => $request->input('search')
        ];

        return view('backend.employee.registration.view',compact('docs'));
    }

    public function create(){
        $docs = new stdClass();
        $docs->designations = Designation::all();
        $docs->genderOptions = Profile::genderOptions();
        return view('backend.employee.registration.add-registration',compact('docs'));
    }

    public function store(StoreEmployeeRegistrationRequest $request){
        try{
            $dto = new EmployeeDTO($request->validatedForDto());
            $image = $request->file('image');
            $this->creatorService->execute($dto, $image);

            return redirect()
                ->route('employee.registration.view')
                ->with([
                    'message' => 'Employee registered successfully.',
                    'alert-type' => 'success', ]);
        }catch(Throwable $e){
            Log::error('Employee registration failed ',[
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'stack' => $e->getTraceAsString(),
                'request_data' => $request->except(['image','_token']),
            ]);
            return redirect()
                ->back()
                ->withInput($request->except(['image']))
                ->withErrors([
                    'message' => 'An error occurred while saving the employee. Please try again.',
                    'alert-type' => 'error'
                ]);
        }
    }

    public function edit($id){

        $docs = new stdClass();
        $docs->designations = Designation::all();
        $docs->genderOptions = Profile::genderOptions();
        $docs->employee = $this->repository->findDTOOrFail($id);

        return view('backend.employee.registration.edit-registration',compact('docs'));
    }

    public function update(UpdateEmployeeRegistrationRequest $request, $id){
        try{

            $dto = new EmployeeDTO($request->validatedForDto());
            $image = $request->file('image');
            $this->updaterService->execute($id, $dto, $image);

            return redirect()
                ->route('employee.registration.view')
                ->with([
                    'message' => 'Employee updated successfully.',
                    'alert-type' => 'success', ]);
        }catch(Throwable $e){
            Log::error('Employee update failed ',[
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'stack' => $e->getTraceAsString(),
                'request_data' => $request->except(['image','_token']),
            ]);
            return redirect()
                ->back()
                ->withInput($request->except(['image']))
                ->withErrors([
                    'message' => 'An error occurred while updating the employee. Please try again',
                    'alert-type' => 'error'
                ]);
        }
    }

    public function getEmployees(Request $request) {
        $perPage = (int) $request->input('limit', 5);
        $perPage = max(1, min($perPage, 100));
        $search = $request->input('search');
        $gender = $request->input('gender');

        // Validate gender against allowed options
        $allowedGenders = array_keys(Profile::genderOptions());
        if ($gender !== null && !in_array($gender, $allowedGenders, true)) {
            $gender = null;
        }

        $employees = $this->repository->paginate(
            perPage: $perPage,
            search: $search,
            filters: ['gender' => $gender],
        );
        $genders = Profile::genderOptions();
        $designations = Designation::all();

        return response()->json([
        'employees' => $employees->items(),
        'pagination' => [
            'from' => $employees->firstItem(),
            'to' => $employees->lastItem(),
            'total' => $employees->total(),
            'per_page' => $employees->perPage(),
            'current_page' => $employees->currentPage(),
            'last_page' => $employees->lastPage(),
        ],
        'search' => $search,
        'genders' => $genders,
        'designations' => $designations,
    ]);
    }

}
