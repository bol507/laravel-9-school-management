<?php

namespace App\Services;

use App\DTO\StudentDTO;
use App\Models\AssignStudent;
use App\Models\DiscountStudent;
use App\Models\User;
use App\Services\Contracts\ImageUploaderInterface;
use App\Services\Contracts\StudentCreatorServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

final class StudentCreatorService implements StudentCreatorServiceInterface {

    private ImageUploaderInterface $imageUploader;

    public function __construct(
        ImageUploaderInterface $imageUploader,
    ){
        $this->imageUploader = $imageUploader;
    }

    public function execute(StudentDTO $data, ?UploadedFile $image = null): AssignStudent {
        return DB::transaction(function() use ($data, $image){
            $imageUrl = null;
            if($image){
                try{
                    $imageUrl = $this->imageUploader->upload($image);
                }catch(RuntimeException $e){

                }
            }

            $code = str_pad((string) random_int(0,9999),4,'0',STR_PAD_LEFT);
            $user = User::create([
                'name' => $data->name,
                'user_type' => 'student',
                'password' => Hash::make($code)
            ]);

            $eloquent = $data->toEloquent();
            $eloquent['code'] = $code;
            $eloquent['id_no'] = $this->generateStudentCode(User::where('user_type','student')->count());
            $eloquent['image'] = $imageUrl;
            $user->profile()->create($eloquent);

            $assign = AssignStudent::create([
                'student_id' => $user->id,
                'year_id' => $eloquent['year_id'],
                'group_id' => $eloquent['group_id'],
                'shift_id' => $eloquent['shift_id'],
                'class_id' => $eloquent['class_id']
            ]);
            $category = FeeCategory::ensureRegistrationFeeExists();
            DiscountStudent::create([
                'assign_student_id' => $assign->id,
                'fee_category_id' => $category->id,
                'discount' => $eloquent['discount']
            ]);
            return $assign;

        });
    }

    private function generateStudentCode($numberValue)
    {
        $number = (int)$numberValue;
        return 'STU' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
