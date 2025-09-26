<?php
namespace App\Strategies;

use App\Services\Contracts\DiscountStrategy;
use App\Models\AssignStudent;
use App\Models\FeeCategory;

class RegistrationDiscountStrategy implements DiscountStrategy
{
    public function calculateDiscount(AssignStudent $assignStudent): float
    {
        static $id;
        $id ??= FeeCategory::getFeeIdByName('Registration fee');

        if (!$id) {
            return 0.0;
        }

        return $assignStudent->calculateDiscount($id);
    }
}
