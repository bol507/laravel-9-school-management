<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExamTypeRequest;
use App\Http\Requests\UpdateExamTypeRequest;
use App\Models\ExamType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ExamTypeController extends Controller
{
    public function ViewExamType(Request $request){
        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1, min($perPage, 100));

        $search = trim((string) $request->input('search', ''));
        $query = ExamType::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $docs = $query->orderBy('name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.setup.exam_type.view-exam', compact('docs', 'search'));
    }

    public function AddExamType(){
        return view('backend.setup.exam_type.add-exam');
    }

    public function StoreExamType(StoreExamTypeRequest $request){
        $validated = $request->validated();
        $notification = [
            'message' => 'An error occurred while saving exam type. Please try again.',
            'alert-type' => 'error'
        ];

        try {
            $examType = DB::transaction(function () use ($validated) {
                return ExamType::UpdateOrCreate(
                    ['name' => $validated['name']], // match attribute
                    $validated // create or update data
                );
            });

            $notification = $this->createNotification($examType);
            return redirect()->route('exam.type.view')->with($notification);
        } catch (Throwable $e) {
            Log::error('Error occurred while saving exam type:', [
                'error' => $e->getMessage()
            ]);
            return redirect()->route('exam.type.add')->withInput()->with($notification);
        }
    }   

    public function EditExamType($id){
         $doc = ExamType::findOrFail($id);
        return view('backend.setup.exam_type.edit-exam',compact('doc'));
    }

    public function UpdateExamType(UpdateExamTypeRequest $request, $id){
        $validated = $request->validated();
        $notification = [
                'message' => 'An error occurred while updating exam type',
                'alert-type' => 'error'
            ];
        try {
            $examType = DB::transaction(function () use ($validated, $id) {
                $founded = ExamType::findOrFail($id);
                $founded ->update($validated);
            });
            $notification = $this->createNotification($examType);
            return redirect()->route('exam.type.view')->with($notification);
        }catch(Throwable $e){
            Log::error('An error occurred while updating exam type',[
                'error' => $e->getMessage()
            ]);
            return redirect()->route('exam.type.edit', $id)
                ->withInput()
                ->with($notification);
        }
    }

    public function DeleteExamType($id){
        try{
            $examType = ExamType::findOrFail($id);
            $examType->delete();
            return redirect()->route('exam.type.view')->with([
                'message' => 'Exam type deleted successfully',
                'alert-type' => 'success'
            ]);
        }catch(Throwable $e){
            Log::error('An error ocurred while deleting exam type',[
                'error' => $e->getMessage()
            ]);
            return redirect()->route('exam.type.view')->with([
            'message' => 'An error occurred while deleting exam',
            'alert-type' => 'danger',
        ]);
        }
    }

    private function createNotification($examType) {
    if ($examType->wasRecentlyCreated) {
        return [
            'message' => 'Exam type created successfully',
            'alert-type' => 'success'
        ];
    } else {
        return [
            'message' => 'Exam type updated successfully',
            'alert-type' => 'warning'
        ];
    }
}
}
