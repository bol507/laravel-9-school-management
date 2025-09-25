<?php

namespace App\Repositories;

use App\DTO\StudentDTO;
use App\Models\AssignStudent;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

final class StudentRepository implements StudentRepositoryInterface {

    private function baseQuery(){
        return AssignStudent::with('user,profile')
            ->whereHas('user',function ($q) {
                $q->where('user_type', '=', 'student');
            });
    }

    public function all():Collection {
        return $this->baseQuery()->get();
    }

    public function findById(string $id): ?AssignStudent
    {
        return $this->baseQuery()->find($id);
    }

    public function findOrFail(string $id): AssignStudent
    {
        $model = $this->findById($id);
        if(!$model){
            throw new ModelNotFoundException("Student with ID {$id} not found.");
        }
        return $model;
    }

    public function findDTOOrFail(string $id): StudentDTO
    {
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
            $query->where(function ($q) use ($search){
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

    private function toDTO(AssignStudent $data): StudentDTO
    {
        $profile = $data->profile;
        $user = $data->user;

        return new StudentDTO([
            //user
            'id'            => $user->id,
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
            'shift_id'      => $data?->shift_id,
        ]);
    }
}
