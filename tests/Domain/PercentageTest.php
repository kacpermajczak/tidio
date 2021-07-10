<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\CalculateSalaryAddon;
use App\Domain\SalaryAddonPercentage;
use App\Tests\FakeClock;
use Brick\Money\Money;
use PHPUnit\Framework\TestCase;

final class PercentageTest extends TestCase
{
    public function testCalculatesPercentageAddon(): void
    {
        // Given
        $salaryAddon = new SalaryAddonPercentage();
        $fakeClock = new FakeClock();
        $fakeClock->setCurrentDate('2021-01-01');
        $command = CalculateSalaryAddon::fromArray(
            [
                'salary_addon_type'             => 'fixed',
                'salary_addon_value'            => null,
                'salary_addon_currency'         => null,
                'salary_addon_percentage'       => '10',
                'date_of_employment'            => '2001-01-01',
                'base_of_remuneration_value'    => '1000',
                'base_of_remuneration_currency' => 'USD',
            ],
            $fakeClock->currentTime()
        );

        // When
        $calculatedSalaryAddon = $salaryAddon->calculate($command);


        // Then
        self::assertEquals(Money::of(100, 'USD'), $calculatedSalaryAddon);
    }
}
