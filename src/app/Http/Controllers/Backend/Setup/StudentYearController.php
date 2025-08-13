<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentYearRequest;
use App\Http\Requests\UpdateStudentYearRequest;
use App\Models\StudentYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentYearController extends Controller
{
    public function ViewStudentYear(Request $request){
        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1, min($perPage, 100));

        $search = trim((string) $request->input('search', ''));
        $query = StudentYear::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $docs = $query->orderBy('name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.setup.student_year.view-year', compact('docs','search'));
    }

    public function AddStudentYear(){
        return view('backend.setup.student_year.add-year');
    }

    public function StoreStudentYear(StoreStudentYearRequest $request){
        try{
            $validated = $request->validated();
            StudentYear::create($validated);
            $notification = [
                'message' => 'Student Year created successfully.',
                'alert-type' => 'success'
            ];

            return redirect()->route('student.year.view')
                ->with($notification);
        } catch (\Throwable $e){
            Log::error('Failed to create student year',[
                'error' => $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while creating the student year',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.year.view')
                ->with($notification);
        }
    }

    public function EditStudentYear($id){
        $doc = StudentYear::findOrFail($id);
        return view('backend.setup.student_year.edit-year',compact('doc'));
    }

    public function UpdateStudentYear(UpdateStudentYearRequest $request, $id){
        try{
            $doc = StudentYear::findOrFail($id);
            $validated = $request->validated();
            $doc->update($validated);
            $notification = [
                'message' => 'Student year updated succesfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.year.view')
                ->with($notification);
        }
        catch (\Throwable $e){
            Log::error('Failed to updated student year',[
                'id'=> $id,
                'error'=> $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while updating the student year',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.year.view')->with($notification);
        }
    }

    public function DeleteStudentYear($id){
        try{
            $doc = StudentYear::findOrFail($id);
            $doc->delete();
            $notification = [
                'message' => 'Student year deleted successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.year.view')->with($notification);
        }
        catch (\Throwable $e){
            Log::warning('Failed to delete student year',[
                'id'=> $id,
                'error'=> $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while deleting the student year',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.year.view')->with($notification);
        }
    }
}
