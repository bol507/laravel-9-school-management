<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentClassRequest;
use App\Http\Requests\UpdateStudentClassRequest;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentClassController extends Controller
{
    public function ViewStudentClass(Request $request){
        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1,min($perPage,100));
        $q = trim((string) $request->input('q',''));
        $query = StudentClass::query();
        if($q){
            $query->where('name','like','%{$q}%');
        }
        $docs = $query->orderBy('name','asc')->paginate($perPage)->appends($request->query());
        return view('backend.setup.student_class.view-class',compact('docs'));
    }

    public function AddStudentClass(){
        return view('backend.setup.student_class.add-class');
    }

    public function StoreStudentClass(StoreStudentClassRequest $request){
        $validated = $request->validated();
        StudentClass::create($validated);
        $notification = [
            'message' => 'Student class added successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('student.class.view')->with($notification);
    }

    public function EditStudentClass($id){
        $doc = StudentClass::findOrFail($id);
        return view('backend.setup.student_class.edit-class',compact('doc'));
    }

    public function UpdateStudentClass(UpdateStudentClassRequest $request, $id){
        try {
            $doc = StudentClass::findOrFail($id);
            $validated = $request->validated();
            $doc->update($validated);
            $notification = [
                'message' => 'Student class updated successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.class.view')->with($notification);
        } catch (\Throwable $e) {
            Log::error('Failed to update student class', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            $notification = [
                'message' => 'An error occurred while updating the student class',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.class.view')->with($notification);
        }
    }

    public function DeleteStudentClass($id){
        try {
            $doc = StudentClass::findOrFail($id);
            $doc->delete();
            $notification = [
                'message' => 'Student class deleted successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.class.view')->with($notification);
        }catch (\Throwable $e) {
            Log::warning('Failed to delete student class', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            $notification = [
                'message' => 'An error occurred while deleting the student class',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.class.view')->with($notification);
        }
    }
}
