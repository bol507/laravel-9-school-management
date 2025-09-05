<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssignSubjectRequest;
use App\Http\Requests\UpdateAssignSubjectRequest;
use App\Models\AssignSubject;
use App\Models\SchoolSubject;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;
use Throwable;

class AssignSubjectController extends Controller
{
    public function ViewAssignSubject(Request $request){
        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1, min($perPage, 100));

        $search = trim((string) $request->input('search', ''));
        $query = AssignSubject::with(['studentClass']); //loading relationship

        if ($search) {
            $query->where('class_id', 'like', "%{$search}%");
        }

        $docs = $query->select('class_id', DB::RAW('SUM(full_mark) as total_full_mark'))
            ->groupBy('class_id')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.setup.assign_subject.view-subject', compact('docs', 'search'));
    }

    public function AddAssignSubject(){
        $docs = new stdClass();
        $docs->classes = StudentClass::all();
        $docs->subjects = SchoolSubject::all();
        return view('backend.setup.assign_subject.add-subject', ['docs' => $docs]);
    }

    public function StoreAssignSubject(StoreAssignSubjectRequest $request){
        try {
            $subjectIds = $request->subject_id;
            $full_marks = $request->full_mark;
            $pass_marks = $request->pass_mark;
            $subjective_marks = $request->subjective_mark;
            $data = [];

            foreach ($subjectIds as $index => $subjectId) {
                $data[] = [
                    'class_id' => $request->class_id,
                    'subject_id' => $subjectId,
                    'full_mark' => $full_marks[$index],
                    'pass_mark' => $pass_marks[$index],
                    'subjective_mark' => $subjective_marks[$index]
                ];
            }

            DB::transaction(function () use ($data) {
                foreach ($data as $row) {
                    AssignSubject::updateOrCreate(
                        [
                            'class_id' => $row['class_id'],
                            'subject_id' => $row['subject_id'],
                        ], //match 
                        [
                            'full_mark' => $row['full_mark'],
                            'pass_mark' => $row['pass_mark'],
                            'subjective_mark' => $row['subjective_mark']
                        ]
                    );
                }
            });

            return redirect()
                ->route('assign.subject.view')
                ->with([
                    'message' => 'Subjects assigned successfully',
                    'alert-type' => 'success'
                ]);
        } catch (Throwable $e) {
            Log::error('Error in Assign Subject: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);
            return redirect()
                ->route('assign.subject.add')
                ->withInput()
                ->with([
                    'message' => 'An error ocurred while saving subjects. Please try again.',
                    'alert-type' => 'error'
                ]);
        }
    }

    public function EditAssignSubject($id){
        $docs = new stdClass();
        $docs = AssignSubject::where('class_id',$id)->orderBy('subject_id','asc')->get();
        $docs->classes = StudentClass::all();
        $docs->subjects = SchoolSubject::all();
        return view('backend.setup.assign_subject.edit-subject',['docs' => $docs]);
    }

    public function UpdateAssignSubject(UpdateAssignSubjectRequest $request, $id){
        $validated = $request->validated();
        if (empty($validated['subject_id'])){
            return redirect()->route('assgin.subject.edit')->with([
                'message' => 'Sorry, you have not selected any subject.',
                'alert-type' => 'error',
            ]);
        }
        
        $subjectIds = $validated['subject_id'];

        $data = collect($subjectIds)
            ->map(function($subjectId, $index) use($validated){
                return[
                    'class_id' => $validated['class_id'],
                    'subject_id' => $subjectId,
                    'full_mark' => $validated['full_mark'][$index],
                    'pass_mark' => $validated['pass_mark'][$index],
                    'subjective_mark' => $validated['subjective_mark'][$index]
                ];
            });
        
        try{
            DB::transaction(function() use($data, $validated){
                $existingSubjects = AssignSubject::where('class_id', $validated['class_id'])
                    ->pluck('subject_id')
                    ->toArray();

                $toDelete = array_diff($existingSubjects, $data->pluck('subject_id')->toArray());

                AssignSubject::where('class_id', $validated['class_id'])
                    ->whereIn('subject_id' , $toDelete)
                    ->delete();

                foreach ($data as $row){
                    AssignSubject::updateOrCreate(
                        [
                            'class_id' => $row['class_id'],
                            'subject_id' => $row['subject_id']
                        ],// match
                        [
                            'full_mark' => $row['full_mark'],
                            'pass_mark' => $row['pass_mark'],
                            'subjective_mark' => $row['subjective_mark']
                        ]
                    );
                }

            });

        }catch(Throwable $e){
            Log::error('An error ocurred while updating subjects: '. $e->getMessage(),[
                'request' => $request->all()
            ]);
            return redirect()
                ->route('assign.subject.edit', $id)
                ->withInput()
                ->with([
                    'message' => 'An error ocurred while updating subjects: '.$e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }

        return redirect()
            ->route('assign.subject.view')
            ->with([
                'message' => 'Assign subjects updated successfully.',
                'alert-type' => 'success'
            ]);

    }
}
