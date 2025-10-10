<?php

namespace App\DTO;

use App\DTO\Traits\DateParsingTrait;
use Carbon\Carbon;
use InvalidArgumentException;

final class EmployeeLeaveDTO
{
    use DateParsingTrait;

    public ?string $id;
    public string $employeeId;
    public string $type; // e.g., 'sick', 'vacation', 'unpaid'
    public Carbon $dateStart;
    public Carbon $dateEnd;
    public ?string $reason;
    public string $status; // e.g., 'pending', 'approved', 'rejected'
    public ?Carbon $appliedAt;
    public ?string $approvedBy;

    public function __construct(array $data)
    {
        if (!isset($data['employeeId']) || !isset($data['type'])) {
            throw new InvalidArgumentException('Required fields missing for LeaveDTO.');
        }

        $this->id = isset($data['id']) ? (string) $data['id'] : null;
        $this->employeeId = (string) $data['employeeId'];
        $this->type = (string) $data['type'];
        $this->reason = isset($data['reason']) ? (string) $data['reason'] : null;
        $this->status = (string) ($data['status'] ?? 'pending');
        $this->approvedBy = isset($data['approvedBy']) ? (string) $data['approvedBy'] : null;

        $this->dateStart = $this->parseDate($data['dateStart']);
        $this->dateEnd = $this->parseDate($data['dateEnd']);
        $this->appliedAt = $this->parseDate($data['appliedAt'] ?? null);
    }
}
