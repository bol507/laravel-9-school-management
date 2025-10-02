<?php

namespace App\Http\Controllers\Backend\Employee;

use App\DTO\SalaryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalaryChangeRequest;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\SalaryRepositoryInterface;
use App\Services\Contracts\SalaryUpdaterServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class EmployeeSalaryController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;
    private SalaryRepositoryInterface $salaryRepository;
    private SalaryUpdaterServiceInterface $updaterService;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SalaryRepositoryInterface $salaryRepository,
        SalaryUpdaterServiceInterface $updaterService
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->salaryRepository = $salaryRepository;
        $this->updaterService = $updaterService;
    }

    public function index(){
        return view('backend.employee.salary.view');
    }

    public function show(string $id): JsonResponse
    {
        
        $dto= $this->salaryRepository->getSalaryHistoryByEmployeeId($id);
        
        if (!$dto) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        return response()->json($dto);
    }

    public function update(StoreSalaryChangeRequest $request, $id): JsonResponse {
        try{
        $dto = New SalaryDTO($request->validatedForDto());
        $this->updaterService->execute($id, $dto);
        return response()->json([
            'message' => 'Salary updated successfully!'
        ],201);
        }catch(Throwable $e){
            Log::error('Employee salary registration failed ',[
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'stack' => $e->getTraceAsString(),
                'request_data' => $request->except(['_token']),
            ]);
            return response()->json(['message' => 'Error saving salary. Please try again'],400);
        }


    }

   
    public function getEmployees(Request $request)
    {
        $perPage = (int) $request->input('limit', 5);
        $perPage = max(1, min($perPage, 100));
        $search = $request->input('search');

        $employees = $this->employeeRepository->paginate(
            perPage: $perPage,
            search: $search,
        );

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
    ]);
    }
}
