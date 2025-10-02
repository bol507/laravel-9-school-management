<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeSalaryChange extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'employee_id',
        'previous_salary',
        'present_salary',
        'increment_salary',
        'effective_date',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

}
