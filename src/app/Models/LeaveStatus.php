<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveStatus extends Model
{
    use HasFactory,HasUuids,SoftDeletes;
    protected $keytype = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'code',
        'color',
    ];
    public function leaves()
    {
        return $this->hasMany(EmployeeLeave::class);
    }
}
