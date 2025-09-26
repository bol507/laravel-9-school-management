<?php
namespace App\DTO;

use Carbon\Carbon;
use InvalidArgumentException;

final class EmployeeDTO
{
   
    public string $name;
    public ?string $id;
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
    public ?string $idNo;
    public ?string $code;
    public ?string $imagePath;

    public function __construct(array $data)
    {
        // Required field
        if (!isset($data['name'])) {
            throw new InvalidArgumentException('The "name" field is required.');
        }
        
        $this->name = (string) $data['name'];
        // Optional fields
        $this->id            = isset($data['id']) ? (string) $data['id'] : '';
        $this->designationId = isset($data['designationId']) ? (string) $data['designationId'] : null;
        $this->fatherName    = isset($data['fatherName']) ? (string) $data['fatherName'] : null;
        $this->motherName    = isset($data['motherName']) ? (string) $data['motherName'] : null;
        $this->mobile        = isset($data['mobile']) ? (string) $data['mobile'] : null;
        $this->address       = isset($data['address']) ? (string) $data['address'] : null;
        $this->gender        = isset($data['gender']) ? (string) $data['gender'] : null;
        $this->religion      = isset($data['religion']) ? (string) $data['religion'] : null;
        $this->imagePath     = isset($data['imagePath']) ? (string) $data['imagePath'] : null;
        $this->code          = isset($data['code']) ? (string) $data['code'] : null;
        $this->idNo          = isset($data['idNo']) ? (string) $data['idNo'] : null;

         // Date fields
        $this->dateBirth = $this->parseDate($data['dateBirth'] ?? null);
        $this->dateJoin = $this->parseDate($data['dateJoin'] ?? null);

        // Numeric fields
        $this->salary = isset($data['salary']) ? (float) $data['salary'] : null;
        
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
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
            'id'             => $this->id,
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

  
    private function parseDate(mixed $value): ?Carbon
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value;
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Invalid date format: ' . $e->getMessage());
        }
    }

    public function getDateBirthForInput(): ?string
    {
        return $this->dateBirth?->format('Y-m-d');
    }

    public function getDateJoinForInput(): ?string
    {
        return $this->dateJoin?->format('Y-m-d');
    }
}
