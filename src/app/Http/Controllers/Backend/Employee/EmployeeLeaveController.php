<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveStatus;
use App\Models\LeaveType;
use App\Repositories\Contracts\EmployeeLeaveRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeLeaveController extends Controller {

    private EmployeeLeaveRepositoryInterface $repository;

    public function __construct(EmployeeLeaveRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function edit($id){
        $leave = $this->repository->findById($id);
        return response()->json(['leave' => $leave]);
    }

    public function getLeaves(Request $request){
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
    }
}
