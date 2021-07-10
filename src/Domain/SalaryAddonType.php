<?php

declare(strict_types=1);

namespace App\Domain;

use MyCLabs\Enum\Enum;

//@todo - change to prebuilt enums on php 8.1
final class SalaryAddonType extends Enum
{
    private const FIXED = 'fixed';
    private const PERCENT = 'percent';

    public static function FIXED(): SalaryAddonType
    {
        return new SalaryAddonType(self::FIXED);
    }

    public static function PERCENT(): SalaryAddonType
    {
        return new SalaryAddonType(self::PERCENT);
    }
}
