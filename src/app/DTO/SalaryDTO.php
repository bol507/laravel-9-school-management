<?php
namespace App\DTO;

use App\DTO\Traits\DateParsingTrait;
use Carbon\Carbon;

final class SalaryDTO {
    use DateParsingTrait;

    public ?string $id;
    public ?string $employeeId;
    public ?float $previousSalary;
    public ?float $presentSalary;
    public ?float  $incrementSalary;
    public ?Carbon $effectiveDate;
    public ?Carbon $createdAt;
    public ?float $newSalary;

    public function __construct(array $data){
        $this->id               = isset($data['id']) ? (string) $data['id'] : '';
        $this->employeeId       = isset($data['employeeId']) ? (string) $data['employeeId'] :null;
        $this->previousSalary   = isset($data['previousSalary']) ? (float) $data['previousSalary'] : null;
        $this->presentSalary    = isset($data['presentSalary']) ? (float) $data['presentSalary'] : null;
        $this->incrementSalary  = isset($data['incrementSalary']) ? (float) $data['incrementSalary'] : null;
        $this->effectiveDate    = $this->parseDate($data['effectiveDate'] ?? null);
        $this->createdAt        = $this->parseDate($data['createdAt'] ?? null);
        $this->newSalary        = isset($data['newSalary']) ? (float) $data['newSalary'] : null;
    }

    public function toArray(): array {
        return [
            'id'                => $this->id,
            'employee_id'       => $this->employeeId,
            'present_salary'    => $this->previousSalary,
            'previous_salary'   => $this->presentSalary,
            'increment_salary'  => $this->incrementSalary,
            'effective_date'    => $this->effectiveDate,
            'created_at'        => $this->createdAt,
            'new_salary'        => $this->newSalary,
        ];
    }

    public function getEffectiveDate(): ?string
    {
        return $this->effectiveDate?->format('Y-m-d');
    }

}
