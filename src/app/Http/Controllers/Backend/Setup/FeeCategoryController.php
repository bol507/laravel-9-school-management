<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeeCategoryRequest;
use App\Http\Requests\UpdateFeeCategoryRequest;
use App\Models\FeeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeeCategoryController extends Controller
{
    public function ViewFeeCategory (Request $request) {
        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1, min($perPage, 100));

        $search = trim((string) $request->input('search', ''));
        $query = FeeCategory::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $docs = $query->orderBy('name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.setup.fee_category.view-fee', compact('docs','search'));
    }

    public function AddFeeCategory ( ) {
        return view('backend.setup.fee_category.add-fee');
    }

    public function StoreFeeCategory (StoreFeeCategoryRequest $request){
         try{
            $validated = $request->validated();
            FeeCategory::create($validated);
            $notification = [
                'message' => 'Fee category created successfully.',
                'alert-type' => 'success'
            ];
            return redirect()->route('fee.category.view')
                ->with($notification);
        } catch (\Throwable $e){
            Log::error('Failed to create fee category',[
                'error' => $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while creating fee category',
                'alert-type' => 'danger'
            ];
            return redirect()->route('fee.category.view')
                ->with($notification);      
        }
    }

     public function EditFeeCategory($id){
        $doc = FeeCategory::findOrFail($id);
        return view('backend.setup.fee_category.edit-fee',compact('doc'));
    }

    public function UpdateFeeCategory(UpdateFeeCategoryRequest $request, $id){
        try{
            $doc = FeeCategory::findOrFail($id);
            $validated = $request->validated();
            $doc->update($validated);
            $notification = [
                'message' => 'Fee category updated successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('fee.category.view')
                ->with($notification);
        }
        catch (\Throwable $e){
            Log::error('Failed to updated fee category',[
                'id'=> $id,
                'error'=> $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while updating fee category',
                'alert-type' => 'danger'
            ];
            return redirect()->route('fee.category.view')->with($notification);
        }
    }

    public function DeleteFeeCategory($id){
        try{
            $doc = FeeCategory::findOrFail($id);
            $doc->delete();
            $notification = [
                'message' => 'Fee category deleted successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('fee.category.view')->with($notification);
        }catch (\Throwable $e){
            Log::warning('Failed to delete fee cateogry',[
                'id'=> $id,
                'error'=> $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while deleting fee category',
                'alert-type' => 'danger'
            ];
            return redirect()->route('fee.category.view')->with($notification);
        }
    }
}
