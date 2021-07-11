<?php

declare(strict_types=1);

namespace App\SharedKernel;

use DateTimeImmutable;

interface Clock
{
    public function currentTime(): DateTimeImmutable;
}