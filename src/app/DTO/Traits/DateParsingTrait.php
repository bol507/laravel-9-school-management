<?php

namespace App\DTO\Traits;

use Carbon\Carbon;
use InvalidArgumentException;

trait DateParsingTrait
{
    private function parseDate(mixed $value): ?Carbon
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value;
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Invalid date format: ' . $e->getMessage());
        }
    }

}
