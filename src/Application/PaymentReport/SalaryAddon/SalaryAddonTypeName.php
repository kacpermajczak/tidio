<?php

declare(strict_types=1);

namespace App\Application\PaymentReport\SalaryAddon;

use App\Domain\SalaryAddonType;
use Assert\Assert;

final class SalaryAddonTypeName
{
    private string $name;

    private function __construct(string $name)
    {
        Assert::that($name)->inArray(SalaryAddonType::toArray());

        $this->name = $name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function asString(): string
    {
        return $this->name;
    }
}
