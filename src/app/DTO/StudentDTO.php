<?php

namespace App\DTO;

use App\DTO\Traits\DateParsingTrait;
use Carbon\Carbon;
use InvalidArgumentException;


/**
 * Data Transfer Object (DTO) representing a student's data.
 * This class encapsulates student-related information and provides a structured way
 * to pass data between layers (e.g., from controllers to repositories or services).
 * It also includes logic to convert the DTO into an array suitable for Eloquent model creation.
 */
final class StudentDTO
{
    use DateParsingTrait;

    /**
     * The full name of the student.
     */
    public string $name;

    /**
     * Unique identifier of the student record (e.g., database ID).
     * May be null if the student hasn't been persisted yet.
     */
    public ?string $id;

    /**
     * Full name of the student's father.
     */
    public ?string $fatherName;

    /**
     * Full name of the student's mother.
     */
    public ?string $motherName;

    /**
     * Student's or guardian's mobile phone number.
     */
    public ?string $mobile;

    /**
     * Physical address of the student.
     */
    public ?string $address;

    /**
     * Gender of the student (e.g., 'male', 'female', 'other').
     */
    public ?string $gender;

    /**
     * Student's declared religion.
     */
    public ?string $religion;

    /**
     * Date of birth of the student, parsed into a Carbon instance.
     */
    public ?Carbon $dateBirth;

    /**
     * National or institutional identification number.
     */
    public ?string $idNo;

    /**
     * Unique enrollment or registration code assigned to the student.
     */
    public ?string $code;

    /**
     * External or internal student identifier (distinct from the primary 'id').
     */
    public ?string $studentId;

    /**
     * Identifier of the class the student belongs to.
     */
    public ?string $classId;

    /**
     * Identifier of the academic year associated with the student.
     */
    public ?string $yearId;

    /**
     * Identifier of the group (e.g., section or batch) the student is assigned to.
     */
    public ?string $groupId;

    /**
     * Identifier of the shift (e.g., morning, evening) the student attends.
     */
    public ?string $shiftId;

    /**
     * Identifier of the fee category applicable to the student.
     */
    public ?string $feeCategoryId;

    /**
     * Discount percentage or amount applied to the student's fees.
     */
    public ?int $discount;

    /**
     * File path to the student's profile image.
     */
    public ?string $imagePath;

    /**
     * Constructs a new StudentDTO instance from an associative array of raw data.
     *
     * @param array $data Associative array containing student attributes.
     *                    The 'name' field is required; all others are optional.
     *
     * @throws InvalidArgumentException If the required 'name' field is missing.
     */
    public function __construct(array $data)
    {
        // Required field validation
        if (!isset($data['name'])) {
            throw new InvalidArgumentException('The "name" field is required.');
        }
        $this->name = (string) $data['name'];

        // Optional string fields
        $this->id = isset($data['id']) ? (string) $data['id'] : null;
        $this->fatherName = isset($data['fatherName']) ? (string) $data['fatherName'] : null;
        $this->motherName = isset($data['motherName']) ? (string) $data['motherName'] : null;
        $this->mobile = isset($data['mobile']) ? (string) $data['mobile'] : null;
        $this->address = isset($data['address']) ? (string) $data['address'] : null;
        $this->gender = isset($data['gender']) ? (string) $data['gender'] : null;
        $this->religion = isset($data['religion']) ? (string) $data['religion'] : null;
        $this->idNo = isset($data['idNo']) ? (string) $data['idNo'] : null;
        $this->code = isset($data['code']) ? (string) $data['code'] : null;
        $this->imagePath = isset($data['imagePath']) ? (string) $data['imagePath'] : null;

        // Date field (parsed using DateParsingTrait)
        $this->dateBirth = $this->parseDate($data['dateBirth'] ?? null);

        // Assignment-related identifiers
        $this->studentId = isset($data['studentId']) ? (string) $data['studentId'] : null;
        $this->classId = isset($data['classId']) ? (string) $data['classId'] : null;
        $this->yearId = isset($data['yearId']) ? (string) $data['yearId'] : null;
        $this->groupId = isset($data['groupId']) ? (string) $data['groupId'] : null; 
        $this->shiftId = isset($data['shiftId']) ? (string) $data['shiftId'] : null;
        $this->feeCategoryId = isset($data['feeCategoryId']) ? (string) $data['feeCategoryId'] : null;

        // Numeric optional field
        $this->discount = isset($data['discount']) ? (int) $data['discount'] : null;
    }

    /**
     * Converts the DTO into an associative array compatible with Eloquent model attributes.
     * This array can be used directly for creating or updating related database records
     * (e.g., User, Profile, AssignStudent models).
     *
     * @return array Associative array of attributes ready for Eloquent mass assignment.
     */
    public function toEloquent(): array
    {
        return [
            // Primary identifier (used when updating existing records)
            'id' => $this->id,

            // User model attributes
            'name' => $this->name,

            // Profile model attributes
            'father_name'     => $this->fatherName,
            'mother_name'     => $this->motherName,
            'mobile'          => $this->mobile,
            'address'         => $this->address,
            'gender'          => $this->gender,
            'religion'        => $this->religion,
            'date_birth'      => $this->dateBirth?->format('Y-m-d'),
            'id_no'           => $this->idNo,
            'code'            => $this->code,
            'image_path'      => $this->imagePath,

            // AssignStudent model attributes
            'student_id'      => $this->studentId,
            'class_id'        => $this->classId,
            'year_id'         => $this->yearId,
            'group_id'        => $this->groupId,
            'shift_id'        => $this->shiftId,

            // Fee-related attributes
            'fee_category_id' => $this->feeCategoryId,
            'discount'        => $this->discount,
        ];
    }

    public function getDateBirthForInput(): ?string
    {
        return $this->dateBirth?->format('Y-m-d');
    }
}
