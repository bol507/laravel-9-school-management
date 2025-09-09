<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignStudent extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

     protected $table = 'assign_students'; 
    protected $fillable = [
        'student_id', 
        'class_id', 
        'year_id', 
        'group_id', 
        'shift_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

  
    public function class()
    {
        return $this->belongsTo(StudentClass::class, 'class_id', 'id'); 
    }

    
    public function year()
    {
        return $this->belongsTo(StudentYear::class, 'year_id', 'id');
    }

   
    public function group()
    {
        return $this->belongsTo(StudentGroup::class, 'group_id', 'id');
    }

    
    public function shift()
    {
        return $this->belongsTo(StudentShift::class, 'shift_id', 'id');
    }
}