<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    //for uuid
    protected $keyType = 'string'; 
    public $incrementing = false; 

    protected $fillable = [
        'id',
        'user_id',
        'mobile',
        'address',
        'gender',
        'religion',
        'blood_group',
        'nationality',
        'status',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
