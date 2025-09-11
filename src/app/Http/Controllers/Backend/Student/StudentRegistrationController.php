<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRegistrationRequest;
use App\Models\AssignStudent;
use App\Models\DiscountStudent;
use App\Models\FeeCategory;
use App\Models\Profile;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use App\Models\StudentYear;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use stdClass;

class StudentRegistrationController extends Controller
{
    public function ViewStudentRegistration(Request $request) {
        $perPage = (int) $request->input('limit',10);
        $perPage = max(1,min($perPage,100));

        /* ---------- find  / pagination  --------------- */
        $query = AssignStudent::with(['user','profile']);
        
        if($request->filled('search')){
            $search = trim($request->input('search'));
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('year_id')) {
            $query->where('year_id', $request->year_id);
        }
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $students = $query
            ->orderBy('student_id')
            ->paginate($perPage)
            ->appends($request->query());

        /* ----------  only object $docs  ---------- */

        $docs = (object)[
            'students'    => $students,           
            'search'      => $request->input('search'),
            'years'       => StudentYear::all()->sortByDesc('name')->values(),
            'classes'     => StudentClass::all()->sortByDesc('name')->values(),
        ];
        
        return view('backend.student.registration.view-registration',compact('docs'));

    }

    public function AddStudentRegistration(){
        $docs = new stdClass();
        $docs->years = StudentYear::all();
        $docs->classes = StudentClass::all();
        $docs->groups = StudentGroup::all();
        $docs->shifts = StudentShift::all();
        $docs->genderOptions = Profile::genderOptions();
        return view('backend.student.registration.add-registration',['docs' => $docs]);
    }

    public function StoreStudentRegistration(StoreStudentRegistrationRequest $request){

        try{
        $validated = $request->validated();
        
        if ($request->hasFile('image')) {
           $image = $request->file('image');

            if ($image->isValid()) {
                $apiKey = env('IMGBB_API_KEY');
                if(!$apiKey){
                    Log::debug('An error in api key:'. $apiKey);
                    throw new \Exception('Error in api key');
                }
                $response = Http::attach(
                    'image',                                   
                    file_get_contents($image->getRealPath()),  // binary content
                    $image->getClientOriginalName()            // optional name
                )->post('https://api.imgbb.com/1/upload?key='.$apiKey);

                if ($response->successful() && ($url = data_get($response->json(), 'data.url'))) {
                    $validated['image'] = $url;
                } else {
                    Log::debug('imgBB multipart error', $response->json());
                    $validated['image'] = null;
                }
            } else {
                throw new \Exception('Uploaded file is not valid.');
            }
        }

        $category = FeeCategory::ensureRegistrationFeeExists();
        $validated['fee_category_id'] = $category->id;

        $registration = DB::transaction(function () use ($validated) {
                $yearRecord = StudentYear::find($validated['year_id']);
                if (!$yearRecord) {
                
                    throw new \Exception('Year not found.');
                }

                $totalStudents = User::where('user_type','student')->count();
                $studentNo = $yearRecord->name.($totalStudents+1);
                $code = rand(0000,9999);

                $user = User::create([
                    'user_type' => 'student', 
                    'name' => $validated['name'], 
                    //'email' => $validated['email'],
                    'password' => Hash::make($code), 
                ]);

                Profile::updateOrCreate(
                    [ 'user_id' => $user->id], //match
                    [
                        'student_no' => $studentNo,
                        'code' => $code,
                        'father_name' => $validated['father_name'],
                        'mother_name' => $validated['mother_name'],
                        'mobile' => $validated['mobile'],
                        'address' => $validated['address'],
                        'gender' => $validated['gender'],
                        'religion' => $validated['religion'],
                        'date_birth' => $validated['date_birth'],
                        'image' => $validated['image']
                    ]
                );

                DiscountStudent::updateOrCreate(
                    ['assign_student_id' => $user->id],
                    [
                        'fee_category_id' => $validated['fee_category_id'],
                        'discount' => $validated['discount']
                    ]
                );

                return AssignStudent::updateOrCreate(
                    ['student_id' => $user->id], //match
                    [
                        'year_id' => $validated['year_id'],
                        'class_id' => $validated['class_id'],
                        'group_id' => $validated['group_id'],
                        'shift_id' => $validated['shift_id'],
                    ]
                );
            });

            $notification = $this->createNotification($registration);
            return redirect()
                ->route('student.registration.view')
                ->with($notification);
        } catch (Exception $e) {
            
            Log::error('An error occurred while processing the request:',[
                'message' =>  $e->getMessage(),
                'request' => $request->except(['image'], true)
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'message' => 'An error occurred while saving the assignation: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }

    }

    private function createNotification($value){
        if ($value->wasRecentlyCreated) {
            return [
                'message' => 'Assignation created successfully',
                'alert-type' => 'success'
            ];
        } else {
            return [
                'message' => 'Assignation updated successfully',
                'alert-type' => 'warning'
            ];
        }
    }


}
