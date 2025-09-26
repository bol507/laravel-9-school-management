<?php
namespace App\Strategies;

use App\Services\Contracts\DiscountStrategy;
use App\Models\AssignStudent;
use App\Models\FeeCategory;

class MonthlyDiscountStrategy implements DiscountStrategy
{
    public function calculateDiscount(AssignStudent $assignStudent): float
    {
        static $id;
        $id ??= FeeCategory::getFeeIdByName('Monthly fee');

        if (!$id) {
            return 0.0;
        }

        return $assignStudent->calculateDiscount($id);
    }
}
