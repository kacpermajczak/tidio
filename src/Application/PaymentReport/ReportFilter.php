<?php

declare(strict_types=1);

namespace App\Application\PaymentReport;

use Assert\Assert;

final class ReportFilter
{
    public static array $availableFilters = ['first_name', 'last_name', 'department_name'];
    private ?string $key;
    private ?string $value;

    private function __construct(?string $key, ?string $value)
    {
        Assert::that($key)->nullOr()->inArray(self::$availableFilters);

        $this->key = $key;
        $this->value = $value;
    }

    public static function create(?string $key, ?string $value): self
    {
        return new self($key, $value);
    }

    public function key(): ?string
    {
        return $this->key;
    }

    public function value(): ?string
    {
        return $this->value;
    }
}
