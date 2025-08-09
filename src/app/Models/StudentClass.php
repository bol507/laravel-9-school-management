<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string'; 
    public $incrementing = false; 

    protected $fillable = [
        'name',
    ];
}
