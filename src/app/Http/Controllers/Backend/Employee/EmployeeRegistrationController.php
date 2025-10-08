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

/**
 * Handles CRUD operations for employee registration in the backend.
 * This controller delegates business logic to dedicated services and repositories,
 * ensuring separation of concerns and maintainability.
 */
class EmployeeRegistrationController extends Controller
{
    private EmployeeUpdaterServiceInterface $updaterService;
    private EmployeeCreatorServiceInterface $creatorService;
    private EmployeeRepositoryInterface $repository;

    /**
     * Inject dependencies via constructor.
     *
     * @param \App\Services\Contracts\EmployeeUpdaterServiceInterface $updaterService
     * @param \App\Services\Contracts\EmployeeCreatorServiceInterface $creatorService
     * @param \App\Repositories\Contracts\EmployeeRepositoryInterface $repository
     */
    public function __construct(
        EmployeeUpdaterServiceInterface $updaterService,
        EmployeeCreatorServiceInterface $creatorService,
        EmployeeRepositoryInterface $repository
    ) {
        $this->updaterService = $updaterService;
        $this->creatorService = $creatorService;
        $this->repository = $repository;
    }

    /**
     * Display a paginated list of employees for the registration view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index()
    {

        return view('backend.employee.registration.view');
    }

    /**
     * Show the form to create a new employee.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $docs = new stdClass();
        $docs->designations = Designation::all();          // For dropdown selection
        $docs->genderOptions = Profile::genderOptions();   // Predefined gender options

        return view('backend.employee.registration.add-registration', compact('docs'));
    }

    /**
     * Store a newly created employee in the database.
     *
     * @param \App\Http\Requests\StoreEmployeeRegistrationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEmployeeRegistrationRequest $request)
    {
        try {
            // Create a validated DTO from the request
            $dto = new EmployeeDTO($request->validatedForDto());
            $image = $request->file('image');

            // Delegate creation to the service layer
            $this->creatorService->execute($dto, $image);

            return redirect()
                ->route('employee.registration.view')
                ->with([
                    'message' => 'Employee registered successfully.',
                    'alert-type' => 'success',
                ]);
        } catch (Throwable $e) {
            // Log the full error for debugging
            Log::error('Employee registration failed', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'stack'   => $e->getTraceAsString(),
                'request_data' => $request->except(['image', '_token']),
            ]);

            // Redirect back with input and a generic user-friendly error
            return redirect()
                ->back()
                ->withInput($request->except(['image']))
                ->withErrors([
                    'message' => 'An error occurred while saving the employee. Please try again.',
                    'alert-type' => 'error'
                ]);
        }
    }

    /**
     * Show the form to edit an existing employee.
     *
     * @param string $id The employee's unique identifier
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $docs = new stdClass();
        $docs->designations = Designation::all();
        $docs->genderOptions = Profile::genderOptions();
        $docs->employee = $this->repository->findDTOOrFail($id); // Throws 404 if not found

        return view('backend.employee.registration.edit-registration', compact('docs'));
    }

    /**
     * Update an existing employee in the database.
     *
     * @param \App\Http\Requests\UpdateEmployeeRegistrationRequest $request
     * @param string $id The employee's unique identifier
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateEmployeeRegistrationRequest $request, $id)
    {
        try {
            $dto = new EmployeeDTO($request->validatedForDto());
            $image = $request->file('image');

            // Delegate update to the service layer
            $this->updaterService->execute($id, $dto, $image);

            return redirect()
                ->route('employee.registration.view')
                ->with([
                    'message' => 'Employee updated successfully.',
                    'alert-type' => 'success',
                ]);
        } catch (Throwable $e) {
            Log::error('Employee update failed', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'stack'   => $e->getTraceAsString(),
                'request_data' => $request->except(['image', '_token']),
            ]);

            return redirect()
                ->back()
                ->withInput($request->except(['image']))
                ->withErrors([
                    'message' => 'An error occurred while updating the employee. Please try again.',
                    'alert-type' => 'error'
                ]);
        }
    }

    /**
     * API endpoint to fetch employees with search, pagination, and gender filtering.
     * Used for dynamic frontend interactions (e.g., AJAX requests).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployees(Request $request)
    {
        $perPage = (int) $request->input('limit', 6);
        $perPage = max(1, min($perPage, 100));
        $search = $request->input('search');
        $gender = $request->input('gender');

        // Validate gender against allowed options to prevent injection
        $allowedGenders = array_keys(Profile::genderOptions());
        if ($gender !== null && !in_array($gender, $allowedGenders, true)) {
            $gender = null;
        }

        // Fetch employees with filters
        $employees = $this->repository->paginate(
            perPage: $perPage,
            search: $search,
            filters: ['gender' => $gender],
        );

        $genders = Profile::genderOptions();
        $designations = Designation::all();

        return response()->json([
            'employees' => $employees->items(), // Array of EmployeeDTO objects
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
