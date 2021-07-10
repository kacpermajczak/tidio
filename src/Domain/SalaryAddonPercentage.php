<?php

declare(strict_types=1);

namespace App\Domain;

use App\SharedKernel\Percent;
use Brick\Money\Money;

final class SalaryAddonPercentage implements SalaryAddon
{
    public function calculate(CalculateSalaryAddon $command): Money
    {
        $remuneration = Money::of(
            $command->getBaseOfRemunerationValue(),
            $command->getBaseOfRemunerationCurrency()
        );

        return $remuneration->multipliedBy(
            Percent::fromScalar($command->getAddonPercentage())->asFloat()
        );
    }

    public function name(): string
    {
        return 'percent';
    }
}
