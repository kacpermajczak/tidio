<?php

declare(strict_types=1);

namespace App\SharedKernel;

use Assert\Assert;

final class Percent
{
    private float $percent;

    private function __construct(float $percent)
    {
        Assert::that($percent)->between(0, 1);

        $this->percent = $percent;
    }

    public static function fromScalar(float $percent): self
    {
        return new self($percent);
    }

    public function asFloat(): float
    {
        return $this->percent;
    }
}
