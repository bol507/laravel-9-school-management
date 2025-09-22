<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Concerns\Listable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class EmployeeRegistrationController extends Controller
{
    use Listable;

    protected function listableModel(): string {
        return User::class;
    }

    protected function listableWith(): array {
        return ['profile'];
    }

    protected function listableSearchColumns(): array {
        return ['name'];   // relationship.column / column
    }

    /*protected function listableFilters(): array{
        return ['year_id', 'class_id'];
    }*/

    protected function listableQueryScope(Builder $query, Request $request): Builder
    {
        return $query->where('user_type', 'employee');
    }

    public function ViewEmployeeRegistration(Request $request){
        $employees = $this->list($request);
        $docs = (object) [
            'employees' => $employees,
            'search' => $request->input('search')
        ];

        return view('backend.employee.registration.view-registration',compact('docs'));
    }

    public function EditEmployeeRegistration($id){

    }

}
