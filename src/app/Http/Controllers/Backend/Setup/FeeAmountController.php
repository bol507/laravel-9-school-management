<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeeAmountRequest;
use App\Http\Requests\UpdateFeeAmountRequest;
use App\Models\FeeCategory;
use App\Models\FeeCategoryAmount;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class FeeAmountController extends Controller
{
    public function ViewFeeAmount(Request $request)
    {
        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1, min($perPage, 100));

        $search = trim((string) $request->input('search', ''));
        $query = FeeCategoryAmount::with(['feeCategory']); //loading relationship

        if ($search) {
            $query->where('fee_category_id', 'like', "%{$search}%");
        }

        $docs = $query->select('fee_category_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('fee_category_id')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.setup.fee_amount.view-fee', compact('docs', 'search'));
    }

    public function AddFeeAmount()
    {
        $docs = new stdClass();
        $docs->fee_categories = FeeCategory::all();
        $docs->classes = StudentClass::all();
        return view('backend.setup.fee_amount.add-fee',  ['docs' => $docs]);
    }

    public function StoreFeeAmount(StoreFeeAmountRequest $request)
    {
        try {
            $classIds = $request->class_id;
            $amounts  = $request->amount;
            $data = [];

            foreach ($classIds as $i => $classId) {
                $data[] = [
                    'fee_category_id' => $request->fee_category_id,
                    'class_id'        => $classId,
                    'amount'          => $amounts[$i],
                ];
            }

            DB::transaction(function () use ($data) {
                foreach ($data as $row) {
                    FeeCategoryAmount::updateOrCreate(
                        [
                            'fee_category_id' => $row['fee_category_id'],
                            'class_id'        => $row['class_id'],
                        ],
                        ['amount' => $row['amount']]
                    );
                }
            });


            return redirect()->route('fee.amount.view')->with([
                'message' => 'Fee amounts saved successfully',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {

            Log::error('Error occurred while saving fee amounts: ' . $e->getMessage());

            return redirect()->route('fee.amount.view')->with([
                'message' => 'An error occurred while saving fee amounts. Please try again.',
                'alert-type' => 'error'
            ]);
        }
    }

    public function EditFeeAmount($id)
    {
        $doc = new stdClass();
        $doc = FeeCategoryAmount::where('fee_category_id', $id)->orderBy('class_id', 'asc')->get();
        $doc->fee_categories = FeeCategory::all();
        $doc->classes = StudentClass::all();
        return view('backend.setup.fee_amount.edit-fee',  ['doc' => $doc]);
    }

    public function UpdateFeeAmount(UpdateFeeAmountRequest $request, $id)
    {
        if (empty($request->class_id)) {
            return redirect()->route('fee.amount.view')->with([
                'message' => 'Sorry, you have not selected any class.',
                'alert-type' => 'error',
            ]);
        }
        $classIds = $request->class_id;
        $amounts  = $request->amount;

        $data = collect($classIds)->map(function ($classId, $i) use ($request, $amounts) {
            return [
                'fee_category_id' => $request->fee_category_id,
                'class_id'        => $classId,
                'amount'          => $amounts[$i] ?? 0, // if no amount default cero.
            ];
        });

        try {
            DB::transaction(function () use ($data, $request) {
                
                $existingClasses = FeeCategoryAmount::where('fee_category_id', $request->fee_category_id)
                    ->pluck('class_id')
                    ->toArray();

                
                $toDelete = array_diff($existingClasses, $data->pluck('class_id')->toArray());
                FeeCategoryAmount::where('fee_category_id', $request->fee_category_id)
                    ->whereIn('class_id', $toDelete)
                    ->delete();

                foreach ($data as $row) {
                    FeeCategoryAmount::updateOrCreate(
                        [
                            'fee_category_id' => $row['fee_category_id'],
                            'class_id'        => $row['class_id'],
                        ],
                        ['amount' => $row['amount']]
                    );
                }
            });
        } catch (\Exception $e) {
            Log::error('Error occurred while updating fee amounts: ' . $e->getMessage());
            return redirect()->route('fee.amount.view')->with([
                'message' => 'An error occurred while updating the amounts: ' . $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }

        $notification = [
            'message' => 'Fee amounts updated successfully.',
            'alert-type' => 'success',
        ];

        return redirect()->route('fee.amount.view')->with($notification);
    }

    public function DeleteFeeAmount($id)
    {
        return redirect()->route('fee.amount.view');
    }
}
