<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLeave extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $keytype = 'string';
    public $incrementing = false;

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'leave_status_id',
        'reason',
        'start_date',
        'end_date',
        'applied_at',
        'approved_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'applied_at' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class,'employee_id','id');
    }

    public function type(){
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(LeaveStatus::class, 'leave_status_id');
    }
}
