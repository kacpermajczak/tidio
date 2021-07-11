<?php

declare(strict_types=1);

namespace App\Domain;

use App\SharedKernel\Clock;
use Brick\Money\Money;

final class SalaryAddonFixed implements SalaryAddon
{
    private Clock $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

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
        $years = $this->clock->currentTime()->diff($command->getDateOfEmployment())->y;

        if ($years > 10) {
            return 10;
        }

        return $years;
    }
}
