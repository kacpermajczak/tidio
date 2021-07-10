<?php

declare(strict_types=1);

namespace App\Domain;

use Brick\Money\Money;

interface SalaryAddon
{
    public function calculate(CalculateSalaryAddon $command): Money;

    public function name(): string;
}
