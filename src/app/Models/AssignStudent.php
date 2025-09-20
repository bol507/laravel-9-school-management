<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function user(){
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function profile(){
        return $this->belongsTo(Profile::class, 'student_id', 'user_id');
    }


    public function class(){
        return $this->belongsTo(StudentClass::class, 'class_id', 'id');
    }


    public function year(){
        return $this->belongsTo(StudentYear::class, 'year_id', 'id');
    }


    public function group(){
        return $this->belongsTo(StudentGroup::class, 'group_id', 'id');
    }


    public function shift(){
        return $this->belongsTo(StudentShift::class, 'shift_id', 'id');
    }

    public function discounts(){
        return $this->hasMany(DiscountStudent::class, 'assign_student_id');
    }

    public function totalDiscount(): Attribute {
        return Attribute::make(
            get: fn () => $this->discounts->sum('discount')
        );
    }

    public function totalDiscountFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->totalDiscount . ' %'
        );
    }

    public function feeCategoryAmounts(){
        return $this->hasMany(FeeCategoryAmount::class, 'class_id', 'class_id');
    }

    public function registrationFeeAmount(): Attribute{
        return Attribute::make(
            get: function () {
                static $registrationId;
                $registrationId ??= FeeCategory::getFeeIdByName('Registration fee');
                if (!$registrationId) {
                    return 0;
                }
                $row = $this->feeCategoryAmounts->firstWhere('fee_category_id', $registrationId);
                return $row?->amount ?? 0;
            }
        );
    }

    public function monthlyFeeAmount(): Attribute {
        return Attribute::make(
            get: function(){
                static $monthId;
                $monthId ??= FeeCategory::getFeeIdByName('Monthly fee');
                if(!$monthId){
                    return 0;
                }
                $row = $this->feeCategoryAmounts->firstWhere('fee_category_id',$monthId);
                return $row?->amount ?? 0;
            }
        );
    }

    public function examFeeAmount(): Attribute {
        return Attribute::make(
            get: function(){
                static $examId;
                $examId ??= FeeCategory::getFeeIdByName('Exam fee');
                if(!$examId){
                    return 0;
                }
                $row = $this->feeCategoryAmounts->firstWhere('fee_category_id',$examId);
                return $row?->amount ?? 0;
            }
        );
    }

    public function studentFee(): Attribute
    {
        return Attribute::make(
            get: function () {
                $discountPct = max(0, min(100, (float) $this->registrationDiscount));
                return round($this->registrationFeeAmount * (100 - $discountPct) / 100, 2);
            },
        );
    }
    /**
     * Registration-fee-specific discount percentage.
     */
    public function registrationDiscount(): Attribute
    {
        return Attribute::make(
            get: function () {
                static $registrationId;
                $registrationId ??= FeeCategory::getFeeIdByName('Registration fee');
                if (!$registrationId) {
                    return 0.0;
                }
                if ($this->relationLoaded('discounts')) {
                    return (float) $this->discounts
                        ->where('fee_category_id', $registrationId)
                        ->sum('discount');
                }
                return (float) $this->discounts()
                    ->where('fee_category_id', $registrationId)
                    ->sum('discount');
            }
        );
    }
}
