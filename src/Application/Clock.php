<?php

declare(strict_types=1);

namespace App\Application;

use DateTimeImmutable;

interface Clock
{
    public function currentTime(): DateTimeImmutable;
}