<?php

namespace App\Services\Contracts;

use App\Models\AssignStudent;

interface DiscountStrategy
{
    public function calculateDiscount(AssignStudent $assignStudent): float;
}
