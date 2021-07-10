<?php

declare(strict_types=1);

namespace App\Domain;

use Brick\Money\Money;

final class SalaryAddonFixed implements SalaryAddon
{
    public function calculate(CalculateSalaryAddon $command): Money
    {
        $addon = Money::of($command->getAddonAmount(), $command->getAddonCurrency());

        return $addon->multipliedBy($this->getMultiplier($command));
    }

    public function name(): string
    {
        return 'fixed';
    }

    private function getMultiplier(CalculateSalaryAddon $command): int
    {
        $years = $command->getCurrentTime()->diff($command->getDateOfEmployment())->y;

        if ($years > 10) {
            return 10;
        }

        return $years;
    }
}
