<?php

namespace App\DTO;

use App\DTO\Traits\DateParsingTrait;
use Carbon\Carbon;
use InvalidArgumentException;

final class StudentDTO {

    use DateParsingTrait;

    public string   $name;
    public ?string  $id;
    public ?string  $fatherName;
    public ?string  $motherName;
    public ?string  $mobile;
    public ?string  $address;
    public ?string  $gender;
    public ?string  $religion;
    public ?Carbon  $dateBirth;
    public ?string  $idNo;
    public ?string  $code;
    public ?string  $studentId;
    public ?string  $classId;
    public ?string  $yearId;
    public ?string  $groupId;
    public ?string  $shiftId;
    public ?string  $feeCategoryId;
    public ?int     $discount;
    public ?string  $imagePath;

    public function __construct(array $data){
        //required fields
        if (!isset($data['name'])) {
            throw new InvalidArgumentException('The "name" field is required.');
        }
        $this->name = (string) $data['name'];
        //optional fields
        $this->id  = isset($data['id']) ? (string) $data['id'] : '';
        $this->fatherName = isset($data['fatherName']) ? (string)$data['fatherName'] : null;
        $this->motherName = isset($data['motherName']) ? (string)$data['motherName'] : null;
        $this->mobile = isset($data['mobile']) ? (string)$data['mobile'] : null;
        $this->address = isset($data['address']) ? (string)$data['address'] : null;
        $this->gender = isset($data['gender']) ? (string)$data['gender'] : null;
        $this->religion = isset($data['religion']) ? (string) $data['religion'] : null;
        //date field
        $this->dateBirth = $this->parseDate($data['dateBirth'] ?? null);
        $this->studentId = isset($data['studentId']) ? (string)$data['studentId'] : null;
        $this->classId = isset($data['classId']) ? (string)$data['classId'] : null;
        $this->yearId = isset($data['yearId']) ? (string)$data['yearId'] : null;
        $this->groupId = isset($data['yearId']) ? (string)$data['groupId'] : null;
        $this->shiftId = isset($data['shiftId']) ? (string)$data['shiftId'] : null;
        $this->feeCategoryId = isset($data['feeCategoryId']) ? (string) $data['feeCategoryId'] : null;
        $this->discount = isset($data['discount']) ? (int) $data['discount'] : null;
    }

}
