<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeCategoryAmount extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'id',
        'fee_category_id',
        'class_id',
        'amount',
    ];


    /**
     * relationship feeCategory
     */
    
    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id','id');
    }

    // relationship StudentClass
    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id','id');
    }

}
