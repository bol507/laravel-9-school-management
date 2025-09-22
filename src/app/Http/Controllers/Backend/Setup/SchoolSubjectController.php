<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolSubjectRequest;
use App\Http\Requests\UpdateSchoolSubjectRequest;
use App\Models\SchoolSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SchoolSubjectController extends Controller
{
    public function ViewSchoolSubject(Request $request) {
        $perPage = (int) $request->input('limit',10);
        $perPage = max(1, min($perPage, 100));
        
        $search = trim((string) $request->input('search',''));
        $query = SchoolSubject::query();

        if($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        $docs = $query->orderBy('name','asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.setup.school_subject.view-school',compact('docs','search'));
    } 

    public function AddSchoolSubject() {
        return view('backend.setup.school_subject.add-school');
    }

    public function StoreSchoolSubject(StoreSchoolSubjectRequest $request) {
        $validated = $request->validated();
        $notification = [
            'message' => 'An error ocurred while saving school subject.',
            'alert-type' => 'error',
        ];

        try{
            $schoolSubject = DB::transaction(function () use ($validated){
                return SchoolSubject::updateOrCreate(
                    ['name' => $validated['name']], //match attribute
                    $validated //create or update data request
                );
            });

            if($schoolSubject->wasRecentlyCreated){
                $notification = [
                    'message' => 'School subject added successfully.',
                    'alert-type'=> 'success'
                ];
            }else{
                $notification = [
                    'message' => 'School subject updated successfully.',
                    'alert-type' => 'warning'
                ];
            }
            return redirect()->route('school.subject.view')->with($notification);
        }catch(Throwable $e){
            Log::error('An Error ocurred while saving school subjet'. $e->getMessage());
            return redirect()->route('school.subject.add')->whithInput()->with($notification);
        }
    }

    public function EditSchoolSubject ($id){
        $doc = SchoolSubject::findorFail($id);
        return view('backend.setup.school_subject.edit-school', compact('doc'));
    }

    public function UpdateSchoolSubject(UpdateSchoolSubjectRequest $request, $id){
        $validated = $request->validated();
        $notification = [
            'message' => 'Something went wrong!',
            'alert-type'=> 'error'
        ];

        try{
            DB::transaction(function() use($validated, $id){
                $schoolSubject = SchoolSubject::findOrFail($id);
                $schoolSubject->update($validated);
            });

            $notification = [
                'message' => 'School subject updated successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('school.subject.view')->with($notification);

        }catch(Throwable $e){
            Log::error('An Error ocurred while updating school subject' . $e->getMessage());
            return redirect()
                ->route('school.subject.edit', $id)
                ->withInput()
                ->with($notification);
        }
    }

    public function DeleteSchoolSubject($id){
        $notification =[
            'message' =>  'Something went wrong!',
            'alert-type' => 'error'
        ];
        try{
             $schoolSubject = SchoolSubject::findOrFail($id);
             $schoolSubject->delete();
             $notification = [
                'message' => 'School subject deleted successfully',
                'alert-type' => 'success'
             ];

             return redirect()
                ->route('school.subject.view')
                ->with($notification);

        }catch(Throwable $e){
            Log::error('An error ocurred while deleting school subject'. $e->getMessage());
            return redirect()
                ->route('school.subject.view')
                ->with($notification);
        }
    }
}
