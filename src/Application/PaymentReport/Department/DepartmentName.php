<?php

declare(strict_types=1);

namespace App\Application\PaymentReport\Department;

use Assert\Assert;

final class DepartmentName
{
    private string $name;

    private function __construct(string $name)
    {
        Assert::that($name)->maxLength(45);

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
