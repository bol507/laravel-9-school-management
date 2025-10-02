<?php
namespace App\DTO;

use App\DTO\Traits\DateParsingTrait;
use Carbon\Carbon;
use InvalidArgumentException;

final class EmployeeDTO
{
    use DateParsingTrait;

    public string $name;
    public ?string $id;
    public ?string $employeeId;
    public ?string $designationId;
    public ?string $designationName;
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
    //salary change
    public ?float $presentSalary;
    public ?float $previousSalary;
    public ?float $incrementSalary;
    public ?Carbon $effectiveDate;

    public function __construct(array $data) {
        // Required field
        if (!isset($data['name'])) {
            throw new InvalidArgumentException('The "name" field is required.');
        }

        $this->name = (string) $data['name'];
        // Optional fields
        $this->id            = isset($data['id']) ? (string) $data['id'] : '';
        $this->employeeId    = isset($data['employeeId']) ? (string) $data['employeeId'] : null;
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
        $this->designationName = isset($data['designationName']) ? (string) $data['designationName'] : null;

         // Date fields
        $this->dateBirth = $this->parseDate($data['dateBirth'] ?? null);
        $this->dateJoin = $this->parseDate($data['dateJoin'] ?? null);

        // Numeric fields
        $this->salary = isset($data['salary']) ? (float) $data['salary'] : null;
        // salary change
        $this->presentSalary = isset($data['presentSalary']) ? (float) $data['presentSalary'] : null;
        $this->previousSalary = isset($data['previousSalary']) ? (float) $data['previousSalary'] : null;
        $this->incrementSalary = isset($data['incrementSalary']) ? (float) $data['incrementSalary'] : null;
        $this->effectiveDate = $this->parseDate($data['effectiveDate'] ?? null);
    }

    public function toArray(): array {
        return [
            'id'                => $this->id,
            'employee_id'       => $this->employeeId,
            'name'              => $this->name,
            'designation_id'    => $this->designationId,
            'father_name'       => $this->fatherName,
            'mother_name'       => $this->motherName,
            'mobile'            => $this->mobile,
            'address'           => $this->address,
            'gender'            => $this->gender,
            'religion'          => $this->religion,
            'date_birth'        => $this->dateBirth?->format('Y-m-d'),
            'date_join'         => $this->dateJoin?->format('Y-m-d'),
            'salary'            => $this->salary,
            'image_path'        => $this->imagePath,
            'id_no'             => $this->idNo,
            'code'              => $this->code,
            'designation_name'  => $this->designationName,
            'present_salary'    => $this->presentSalary,
            'previous_salary'   => $this->previousSalary,
            'increment_salary'  => $this->incrementSalary,
            'effective_date'   => $this->effectiveDate,
        ];
    }



    public function getDateBirthForInput(): ?string
    {
        return $this->dateBirth?->format('Y-m-d');
    }

    public function getDateJoinForInput(): ?string
    {
        return $this->dateJoin?->format('Y-m-d');
    }

    public function formattedSalary(): string
    {
        if (is_null($this->salary)) {
            return 'N/A';
        }

        return number_format($this->salary, 2, '.', ',') . ' USD$';
    }
}
