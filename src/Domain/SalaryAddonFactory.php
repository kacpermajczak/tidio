<?php

declare(strict_types=1);

namespace App\Domain;

use App\SharedKernel\Clock;

final class SalaryAddonFactory
{
    private Clock $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    public function create(CalculateSalaryAddon $command): SalaryAddon
    {
        return match ($command->getAddonType()) {
            SalaryAddonType::PERCENT()->getValue() => new SalaryAddonPercentage(),
            SalaryAddonType::FIXED()->getValue() => new SalaryAddonFixed($this->clock),
            default => throw new \InvalidArgumentException(),
        };
    }
}
