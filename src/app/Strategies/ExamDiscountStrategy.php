<?php
namespace App\Strategies;

use App\Services\Contracts\DiscountStrategy;
use App\Models\AssignStudent;
use App\Models\FeeCategory;

class ExamDiscountStrategy implements DiscountStrategy
{
    public function calculateDiscount(AssignStudent $assignStudent): float
    {
        static $id;
        $id ??= FeeCategory::getFeeIdByName('Exam fee');

        if (!$id) {
            return 0.0;
        }
        $discount = $assignStudent->calculateDiscount($id);
        return $discount;
    }
}
