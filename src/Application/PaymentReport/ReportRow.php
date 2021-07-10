<?php

declare(strict_types=1);

namespace App\Application\PaymentReport;

use App\Application\PaymentReport\Employee\EmployeeViewModel;

final class ReportRow
{
    public const FIRST_NAME = 'Imię';
    public const LAST_NAME = 'Nazwisko';
    public const DEPARTMENT = 'Dział';
    public const REMUNERATION = 'Podstawa Wynagrodzenia (kwota)';
    public const SALARY_ADDON_AMOUNT = 'Dodatek do podstawy (kwota)';
    public const SALARY_ADDON_TYPE = 'Typ dodatku (typ % lub stały)';
    public const TOTAL_REMUNERATION = 'Wynagrodzenie wraz z dodatkiem (kwota)';

    private EmployeeViewModel $employee;

    private function __construct(EmployeeViewModel $employee)
    {
        $this->employee = $employee;
    }

    public static function create(EmployeeViewModel $employee): self
    {
        return new self($employee);
    }

    public function asArray(): array
    {
        return [
            self::FIRST_NAME          => $this->employee->firstName(),
            self::LAST_NAME           => $this->employee->lastName(),
            self::DEPARTMENT          => $this->employee->departmentName(),
            self::REMUNERATION        => $this->employee->remuneration()->formatTo('en_US'),
            self::SALARY_ADDON_AMOUNT => $this->employee->salaryAddonAmount()->formatTo('en_US'),
            self::SALARY_ADDON_TYPE   => $this->employee->salaryAddonTypeName(),
            self::TOTAL_REMUNERATION  => $this->employee->totalRemuneration()->formatTo('en_US'),
        ];
    }
}
