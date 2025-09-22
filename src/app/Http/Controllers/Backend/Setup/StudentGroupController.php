<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentGroupRequest;
use App\Http\Requests\UpdateStudentGroupRequest;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentGroupController extends Controller
{
    public function ViewStudentGroup(Request $request){
        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1,min($perPage,100));
        $search = trim((string) $request->input('search',''));
        $query = StudentGroup::query();
        if($search){
            $query->where('name','like',"%{$search}%");
        }
        $docs = $query
            ->orderBy('name','asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.setup.student_group.view-group',compact('docs','search'));
    }

    public function AddStudentGroup(){
        return view('backend.setup.student_group.add-group');
    }

    public function StoreStudentGroup(StoreStudentGroupRequest $request){
        try{
            $validated = $request->validated();
            StudentGroup::create($validated);
            $notification = [
                'message' => 'Student group created successfully.',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.group.view')
                ->with($notification);
        } catch (\Throwable $e){
            Log::error('Failed to create student group',[
                'error' => $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while creating the student group',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.group.view')
                ->with($notification);      
        }
    }

    public function EditStudentGroup($id){
        $doc = StudentGroup::findOrFail($id);
        return view('backend.setup.student_group.edit-group',compact('doc'));
    }

    public function UpdateStudentGroup(UpdateStudentGroupRequest $request, $id){
        try{
            $doc = StudentGroup::findOrFail($id);
            $validated = $request->validated();
            $doc->update($validated);
            $notification = [
                'message' => 'Student group updated successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.group.view')
                ->with($notification);
        }
        catch (\Throwable $e){
            Log::error('Failed to updated student group',[
                'id'=> $id,
                'error'=> $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while updating the student group',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.group.view')->with($notification);
        }
    }

    public function DeleteStudentGroup($id){
        try{
            $doc = StudentGroup::findOrFail($id);
            $doc->delete();
            $notification = [
                'message' => 'Student group deleted successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('student.group.view')->with($notification);
        }catch (\Throwable $e){
            Log::warning('Failed to delete student group',[
                'id'=> $id,
                'error'=> $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while deleting the student group',
                'alert-type' => 'danger'
            ];
            return redirect()->route('student.group.view')->with($notification);
        }
    }
}
