<?php

declare(strict_types=1);

namespace App\Domain;

final class SalaryAddonFactory
{
    public function create(CalculateSalaryAddon $command): SalaryAddon
    {
        return match ($command->getAddonType()) {
            SalaryAddonType::PERCENT()->getValue() => new SalaryAddonPercentage(),
            SalaryAddonType::FIXED()->getValue() => new SalaryAddonFixed(),
            default => throw new \InvalidArgumentException(),
        };
    }
}
