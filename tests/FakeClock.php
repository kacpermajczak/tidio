<?php

declare(strict_types=1);

namespace App\Tests;

use App\Application\Clock;
use Assert\Assert;
use DateTimeImmutable;
use DateTimeZone;

final class FakeClock implements Clock
{
    private ?DateTimeImmutable $currentTime = null;

    public function currentTime(): DateTimeImmutable
    {
        Assert::that($this->currentTime)->isInstanceOf(
            DateTimeImmutable::class,
            'You should first call FakeClock::setCurrentTime() or setCurrentDate()'
        );

        return $this->currentTime;
    }

    public function setCurrentDate(string $date): void
    {
        $this->setCurrentTimeFromFormattedString('Y-m-d', $date);
    }

    private function setCurrentTimeFromFormattedString(string $format, string $time): void
    {
        $currentTime = DateTimeImmutable::createFromFormat($format, $time, new DateTimeZone('UTC'));
        Assert::that($currentTime)->isInstanceOf(DateTimeImmutable::class);

        $this->currentTime = $currentTime;
    }
}