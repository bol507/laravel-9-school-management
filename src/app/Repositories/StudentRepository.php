<?php

namespace App\Repositories;

use App\DTO\StudentDTO;
use App\Models\AssignStudent;
use App\Models\DiscountStudent;
use App\Models\FeeCategory;
use App\Models\User;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class StudentRepository implements StudentRepositoryInterface {

    private function baseQuery(){
        return AssignStudent::with(['user','profile','discount'])
            ->whereHas('user',function ($q) {
                $q->where('user_type', '=', 'student');
            });
    }

    public function all():Collection {
        return $this->baseQuery()->get();
    }

    public function findById(string $id): ?AssignStudent {
        return $this->baseQuery()->find($id);
    }

    public function findOrFail(string $id): AssignStudent {
        $model = $this->findById($id);
        if(!$model){
            throw new ModelNotFoundException("Student with ID {$id} not found.");
        }
        return $model;
    }

    public function findDTOOrFail(string $id): StudentDTO {
        $model = $this->findOrFail($id);
        return $this->toDTO($model);
    }

    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string $orderBy = 'created_at',
        string $orderDirection = 'desc'
    ): LengthAwarePaginator {
        $query = $this->baseQuery();

        //Search funcionality
        if(!empty($search)){
            $query->whereHas('user', function ($q) use ($search){
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        //apply filters
        foreach($filters as $key => $value){
            if ($value !== null && $value !== ''){
                $query->where($key,$value);
            }
        }

        //Order by and order directions
        $allowedColumn  = ['name','created_at'];
        if(!in_array($orderBy, $allowedColumn, true)){
            $orderBy = 'created_at';
        }

        $orderDirection = strtolower($orderDirection) === 'desc' ? 'desc' : 'asc';

        return $query
                ->orderBy($orderBy, $orderDirection)
                ->paginate($perPage);


    }

    public function createStudent(
        array $userData,
        array $profileData,
        array $assignData,
        int $discount
    ): AssignStudent {
        return DB::transaction(function () use ($userData, $profileData, $assignData, $discount) {
            // 1. Create user
            $user = User::create($userData);

            // 2. Create profile
            $user->profile()->create($profileData);

            // 3. Create assignation
            $assignData['student_id'] = $user->id;
            $assign = AssignStudent::create($assignData);

            // 4. Create discount
            $feeCategory = FeeCategory::ensureRegistrationFeeExists();
            DiscountStudent::create([
                'assign_student_id' => $assign->id,
                'fee_category_id' => $feeCategory->id,
                'discount' => $discount,
            ]);

            return $assign;
        });
    }

    public function updateStudent(
        string $id,
        array $userData,
        array $profileData,
        array $assignData,
        int $discount
    ): AssignStudent {
        return DB::transaction(function () use ($id, $userData, $profileData, $assignData, $discount) {
            $assign = $this->baseQuery()->findOrFail($id);

            $assign->user->update($userData);

            $assign->user->profile()->update($profileData);

            $assign->update($assignData);

            $feeCategory = FeeCategory::ensureRegistrationFeeExists();
            $discountRecord = $assign->discount()->first();

            if ($discountRecord) {
                $discountRecord->update([
                    'fee_category_id' => $feeCategory->id,
                    'discount' => $discount,
                ]);
            } else {
                DiscountStudent::create([
                    'assign_student_id' => $assign->id,
                    'fee_category_id' => $feeCategory->id,
                    'discount' => $discount,
                ]);
            }


            $assign->load(['user', 'profile', 'discount']);

            return $assign;
        });
    }

    public function countStudents(): int{
        return User::where('user_type', 'student')->count();
    }

    private function toDTO(AssignStudent $data): StudentDTO {
        $profile = $data->profile;
        $user = $data->user;
        $discount = $data->discount->first();

        return new StudentDTO([
            //user
            'id'            => $data->id,
            'name'          => $user->name,
            //profile
            'gender'        => $profile?->gender,
            'fatherName'    => $profile?->father_name,
            'motherName'    => $profile?->mother_name,
            'mobile'        => $profile?->mobile,
            'address'       => $profile?->address,
            'religion'      => $profile?->religion,
            'dateBirth'     => $profile?->date_birth,
            'idNo'          => $profile?->id_no !== null ? (string) $profile->id_no : null,
            'code'          => $profile?->code !== null ? (int) $profile->code : null,
            'imagePath'     => $profile?->image_path,
            //assign
            'studentId'     => $data?->student_id,
            'classId'       => $data?->class_id,
            'yearId'        => $data?->year_id,
            'groupId'       => $data?->group_id,
            'shiftId'       => $data?->shift_id,
            //discount
            'feeCategoryId' => $discount?->fee_category_id,
            'discount'      => $discount?->discount,
        ]);
    }


}
