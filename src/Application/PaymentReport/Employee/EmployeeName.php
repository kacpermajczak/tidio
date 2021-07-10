<?php

declare(strict_types=1);

namespace App\Application\PaymentReport\Employee;

use Assert\Assert;

final class EmployeeName
{
    private string $firstName;
    private string $lastName;

    private function __construct(string $firstName, string $lastName)
    {
        Assert::that($firstName)->maxLength(45);
        Assert::that($lastName)->maxLength(45);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function fromScalars(string $firstName, string $lastName): self
    {
        return new self($firstName, $lastName);
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }
}
