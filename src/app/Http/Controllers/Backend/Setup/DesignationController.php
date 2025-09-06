<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Models\Designation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DesignationController extends Controller
{
    public function ViewDesignation(Request $request){
        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1, min($perPage, 100));

        $search = trim((string) $request->input('search', ''));
        $query = Designation::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $docs = $query->orderBy('name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.setup.designation.view-designation', compact('docs', 'search'));
    }

    public function AddDesignation(){
        return view('backend.setup.designation.add-designation');
    }

    public function StoreDesignation(StoreDesignationRequest $request){
        $validated = $request->validated();
        try {
            $destination = DB::transaction(function () use ($validated) {
                return Designation::updateOrCreate(
                    ['name' => $validated['name']], //match
                    $validated
                );
            });
            $notification = $this->createNotification($destination);
            return redirect()
                ->route('designation.view')
                ->with($notification);
        } catch (Exception $e) {
            Log::error('Error occurred while saving designation: ', [
                'error' => $e->getMessage(),
                'request' => $request
            ]);
            return redirect()
                ->route('designation.add')
                ->withInput()
                ->with([
                    'message' => 'An error occurred while saving designation',
                    'alert-type' => 'error'
                ]);
        }
    }

    public function EditDesignation($id){
        $doc = Designation::findOrFail($id);
        return view('backend.setup.designation.edit-designation',compact('doc'));
    }

    public function UpdateDesignation(UpdateDesignationRequest $request,$id){
        $validated = $request->validated();
        try{
           $designation = DB::transaction(function() use($validated, $id){
                return Designation::updateOrCreate(
                    ['id' => $id], //match
                    $validated
                );
            });
            $notification = $this->createNotification($designation);
            return redirect()
                ->route('designation.view')
                ->with($notification);
        }catch(Exception $e){
            Log::error('An error occurred while updating designation',[
                "request" => $request,
                "error" => $e->getMessage()
            ]);
            return redirect()
                ->route('designation.edit',$id)
                ->withInput()
                ->with([
                    'message' => 'An error occurred while updating designation'.$e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }

    public function DeleteDesignation($id){
        try{
            $designation = Designation::findOrFail($id);
            $designation->delete();
            return redirect()
                ->route('designation.view')
                ->with([
                    'message' => "Designation deleted successfully",
                    'alert-type' => 'success'
                ]);
        }catch(Exception $e){
            Log::error('An error occurred when deleting designation'. $e->getMessage());
            return redirect('designation.view')
                ->with([
                    'message' => 'An error occurred when deleting designation',
                    'alert-type' => 'error'
                ]);
        }
    }

    private function createNotification($designation){
        if ($designation->wasRecentlyCreated) {
            return [
                'message' => 'Designation created successfully',
                'alert-type' => 'success'
            ];
        } else {
            return [
                'message' => 'Designation updated successfully',
                'alert-type' => 'warning'
            ];
        }
    }
}
