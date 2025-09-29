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

        if (is_string($value) && trim($value) === '') {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Invalid date format: ' . $e->getMessage());
        }
    }

}
