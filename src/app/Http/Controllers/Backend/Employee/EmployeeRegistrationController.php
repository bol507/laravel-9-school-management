<?php

namespace App\Http\Controllers\Backend\Employee;

use App\DTO\EmployeeDTO;
use App\Http\Controllers\Concerns\Listable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRegistrationRequest;
use App\Http\Requests\UpdateEmployeeRegistrationRequest;
use App\Models\Designation;
use App\Models\Profile;
use App\Models\User;
use App\Services\EmployeeCreatorService;
use App\Services\EmployeeUpdaterService;
use App\Services\ImgBbUploaderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use stdClass;
use Throwable;

class EmployeeRegistrationController extends Controller
{
    use Listable;
    private EmployeeUpdaterService $updaterService;
    private EmployeeCreatorService $creatorService;

    public function __construct(
        EmployeeUpdaterService $updaterService,
        EmployeeCreatorService $creatorService,
    ) {
        $this->updaterService = $updaterService;
        $this->creatorService = $creatorService;
    }

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

    public function AddEmployeeRegistration(){
        $docs = new stdClass();
        $docs->designations = Designation::all();
        $docs->genderOptions = Profile::genderOptions();
        return view('backend.employee.registration.add-registration',compact('docs'));
    }

    public function StoreEmployeeRegistration(StoreEmployeeRegistrationRequest $request){
        try{
            $dto = EmployeeDTO::fromRequest($request->validatedForDto());
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

    public function EditEmployeeRegistration($id){
        $docs = new stdClass();
        $docs->designations = Designation::all();
        $docs->genderOptions = Profile::genderOptions();
        $docs->employee = User::with(['profile'])
            ->where('id',$id)
            ->firstOrFail();
        return view('backend.employee.registration.edit-registration',compact('docs'));
    }

    public function UpdateEmployeeRegistrarion(UpdateEmployeeRegistrationRequest $request, $id){
        try{
            $data = $request->dto($id);

            if ($request->hasFile('image')) {
                $imageUploadService = new ImgBbUploaderService();
                $validated['image'] = $imageUploadService->upload($request->file('image'));
            }


            if ($request->hasFile('image')) {
                $imgBB = new ImgBbUploaderService();
                $path =  $imgBB->upload($request->file('image'));
                $data = new EmployeeDTO(
                    ...((array) $data) + ['imagePath' => $path]
                );
            }

            $this->updaterService->execute($id, $data);

            return redirect()
                ->route('employee.registration.view')
                ->with([
                    'message' => 'Employee updated successfully.',
                    'alert-type' => 'success', ]);
        }catch(Exception $e){
            Log::error('An error occurred while processing the request: ',[
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'request' => $request->except(['image']),
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'message' => 'An error occurred while updateing the employee: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }

}
