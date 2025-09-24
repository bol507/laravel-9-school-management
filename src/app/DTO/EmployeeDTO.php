<?php
namespace App\DTO;

use Carbon\Carbon;

final class EmployeeDTO
{
    public string $name;
    public ?string $designationId;
    public ?string $fatherName;
    public ?string $motherName;
    public ?string $mobile;
    public ?string $address;
    public ?string $gender;
    public ?string $religion;
    public ?Carbon $dateBirth;
    public ?Carbon $dateJoin;
    public ?float $salary;
    public ?int $idNo;
    public ?string $code;
    public ?string $imagePath;

    public function __construct(array $data)
    {
        $this->name          = $data['name'];
        $this->designationId = $data['designationId'] ?? null;
        $this->fatherName    = $data['fatherName'] ?? null;
        $this->motherName    = $data['motherName'] ?? null;
        $this->mobile        = $data['mobile'] ?? null;
        $this->address       = $data['address'] ?? null;
        $this->gender        = $data['gender'] ?? null;
        $this->religion      = $data['religion'] ?? null;
        $this->dateBirth     = $data['dateBirth'] ?? null;
        $this->dateJoin      = $data['dateJoin'] ?? null;
        $this->salary        = $data['salary'] ?? null;
        $this->imagePath     = $data['imagePath'] ?? null;
        $this->idNo          = $data['idNo'] ?? null;
        $this->code          = $data['code'] ?? null;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'designationId' => $this->designationId,
            'fatherName' => $this->fatherName,
            'motherName' => $this->motherName,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'gender' => $this->gender,
            'religion' => $this->religion,
            'dateBirth' => $this->dateBirth,
            'dateJoin' => $this->dateJoin,
            'salary' => $this->salary,
            'imagePath' => $this->imagePath,
            'idNo' => $this->idNo,
            'code' => $this->code,
        ];
    }

    public function toEloquent(): array
    {
        return [
            'name'           => $this->name,
            'designation_id' => $this->designationId,
            'father_name'    => $this->fatherName,
            'mother_name'    => $this->motherName,
            'mobile'         => $this->mobile,
            'address'        => $this->address,
            'gender'         => $this->gender,
            'religion'       => $this->religion,
            'date_birth'     => $this->dateBirth?->format('Y-m-d'),
            'date_join'      => $this->dateJoin?->format('Y-m-d'),
            'salary'         => $this->salary,
            'image_path'     => $this->imagePath,
            'id_no'          => $this->idNo,
            'code'           => $this->code,
        ];
    }

    public static function fromRequest(array $validated): self
    {
        return new self([
            'name'          => $validated['name'],
            'designationId' => $validated['designation_id'] ?? null,
            'fatherName'    => $validated['father_name']    ?? null,
            'motherName'    => $validated['mother_name']    ?? null,
            'mobile'        => $validated['mobile']         ?? null,
            'address'       => $validated['address']        ?? null,
            'gender'        => $validated['gender']         ?? null,
            'religion'      => $validated['religion']       ?? null,
            'dateBirth'     => isset($validated['date_birth'])
                                ? Carbon::parse($validated['date_birth'])
                                : null,
            'dateJoin'      => isset($validated['date_join'])
                                ? Carbon::parse($validated['date_join'])
                                : null,
            'salary'        => isset($validated['salary'])
                                ? (float) $validated['salary']
                                : null,
            'imagePath'     => null, // Image handling is done in the controller
            'idNo'          => $validated['id_no'] ?? null,
            'code'          => $validated['code']  ?? null,
        ]);
    }
}
