<?php

namespace App\DTO;

use App\DTO\Traits\DateParsingTrait;
use App\Models\EmployeeLeave;
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

    public static function fromModel(EmployeeLeave $leave): self
    {
        return new self(self::map($leave));
    }

    private static function map(EmployeeLeave $l): array
    {
        return [
            'id'         => $l->id,
            'employeeId' => $l->employee_id,
            'type'       => $l->type?->code  ?? 'unknown',
            'status'     => $l->status?->code ?? 'pending',
            'reason'     => $l->reason,
            'dateStart'  => $l->date_start->toISOString(),
            'dateEnd'    => $l->date_end->toISOString(),
            'appliedAt'  => $l->applied_at?->toDateTimeString(),
            'approvedBy' => $l->approved_by,
        ];
    }
}
