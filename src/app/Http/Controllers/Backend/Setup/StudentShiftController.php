<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentShiftRequest;
use App\Http\Requests\UpdateStudentShiftRequest;
use App\Models\StudentShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentShiftController extends Controller
{
    public function ViewStudentShift(Request $request){
        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1,min($perPage,100));
        $search = trim((string) $request->input('search',''));
        $query = StudentShift::query();
        if($search){
            $query->where('name','like',"%{$search}%");
        }
        $docs = $query
            ->orderBy('name','asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.setup.student_shift.view-shift',compact('docs','search'));
    }

    public function AddStudentShift(){
        return view('backend.setup.student_shift.add-shift');
    }

    public function StoreStudentShift(StoreStudentShiftRequest $request){
        try{
            $validated = $request->validated();
            StudentShift::create($validated);
            $notification = [
                'message' => 'Student shift created successfully.',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.shift.view')
                ->with($notification);
        } catch (\Throwable $e){
            Log::error('Failed to create student shift',[
                'error' => $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while creating the student shift',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.shift.view')
                ->with($notification);
        }
    }

    public function EditStudentShift($id){
        $doc = StudentShift::findOrFail($id);
        return view('backend.setup.student_shift.edit-shift',compact('doc'));
    }

    public function UpdateStudentShift(UpdateStudentShiftRequest $request, $id){
        try{
            $doc = StudentShift::findOrFail($id);
            $validated = $request->validated();
            $doc->update($validated);
            $notification = [
                'message' => 'Student shift updated successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.shift.view')
                ->with($notification);
        }
        catch (\Throwable $e){
            Log::error('Failed to updated student shift',[
                'id'=> $id,
                'error'=> $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while updating the student shift',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.shift.view')->with($notification);
        }
    }

    public function DeleteStudentShift($id){
        try{
            $doc = StudentShift::findOrFail($id);
            $doc->delete();
            $notification = [
                'message' => 'Student shift deleted successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.shift.view')->with($notification);
        }catch (\Throwable $e){
            Log::warning('Failed to delete student shift',[
                'id'=> $id,
                'error'=> $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while deleting the student shift',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.shift.view')->with($notification);
        }
    }
}
