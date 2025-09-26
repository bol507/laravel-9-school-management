<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeCategory extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description'
    ];

    
    public static function ensureDefaultFeesExist(array $names = ['Registration fee', 'Monthly fee', 'Exam fee'])
    {
        foreach ($names as $name) {
            self::firstOrCreate(['name' => $name]);
        }
    }

    public static function ensureRegistrationFeeExists()
    {
        return self::firstOrCreate(['name' => 'Registration fee']);
    }
    
    //use FeeCategory::registration()->value('id');
    public function scopeRegistration($query)
    {
        return $query->where('name', 'Registration fee');
    }

    /**
     * Scope to get fee category by name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByName($query, string $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Get fee category ID by name.
     *
     * @param string $name
     * @return string|null
     */
    public static function getFeeIdByName(string $name)
    {
        $fee = self::where('name', $name)->first();
        return $fee ? $fee->id : null;
    }
}
