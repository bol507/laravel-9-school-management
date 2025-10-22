<?php

namespace App\Http\Controllers\Backend\Employee;

use App\DTO\EmployeeLeaveDTO;
use App\Http\Controllers\Controller;
use App\Models\LeaveStatus;
use App\Models\LeaveType;
use App\Queries\EmployeeLeave\EmployeeLeaveFilters;
use App\Queries\EmployeeLeave\EmployeeLeaveQueryBuilder;
use App\Repositories\Contracts\EmployeeLeaveRepositoryInterface;
use App\Services\Contracts\EmployeeLeaveCreatorServiceInterface;
use App\Services\Contracts\EmployeeLeaveServiceInterface;
use Database\Seeders\EmployeeLeaveSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeLeaveController extends Controller
{



    public function __construct(
        private EmployeeLeaveRepositoryInterface $repository,
        private EmployeeLeaveServiceInterface $service,
        private EmployeeLeaveCreatorServiceInterface $creator,
    ){}

    public function store(Request $request) {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'date_start' => 'required|date|after_or_equal:today',
            'date_end' => 'required|date|after_or_equal:date_start',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $this->creator->execute($validated);

            return response()->json([
                'message' => 'Leave created successfully',
            ], 201);

        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Error creating leave: ' . $e->getMessage());
            return response()->json(['error' => 'Error create leave, Please try again'], 500);
        }
    }

    public function getLeaveByEmployee(Request $request, $id) {
        $perPage = (int) $request->input('limit', 6);
        $perPage = max(1, min($perPage, 100));

        $paginator = EmployeeLeaveQueryBuilder::make()
            ->forEmployee($id)
            ->orderBy('date_start', 'desc')
            ->paginate($perPage);
        //map to DTOs
        $dtoCollection = $paginator
            ->getCollection()
            ->map(fn($l) => EmployeeLeaveDTO::fromModel($l));

        $paginator->setCollection($dtoCollection);

        return response()->json([
            'leaves'     => $dtoCollection,
            'pagination' => $paginator->jsonSerialize(),
            'types'      => LeaveType::all(),
            'statuses'   => LeaveStatus::all(),
        ]);
    }

    /*public function getLeaves(Request $request) {
        $perPage = (int) $request->input('limit', 6);
        $perPage = max(1, min($perPage, 100));
        $search = $request->input('search');


        $leaves = $this->repository->paginate(
            perPage: $perPage,
            search: $search,

        );

        $types = LeaveType::all();
        $statuses = LeaveStatus::all();



        return response()->json([
            'leaves' => $leaves->items(),
            'pagination' => [
                'from' => $leaves->firstItem(),
                'to' => $leaves->lastItem(),
                'total' => $leaves->total(),
                'per_page' => $leaves->perPage(),
                'current_page' => $leaves->currentPage(),
                'last_page' => $leaves->lastPage(),
            ],
            'search' => $search,
            'types' => $types,
            'statuses' => $statuses,
        ]);
    }*/
}
