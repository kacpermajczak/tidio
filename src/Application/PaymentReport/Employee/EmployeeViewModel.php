<?php

declare(strict_types=1);

namespace App\Application\PaymentReport\Employee;

use App\Application\PaymentReport\Department\DepartmentViewModel;
use Brick\Money\Money;
use DateTimeImmutable;

//view model
final class EmployeeViewModel
{
    private EmployeeName $employeeName;
    private DateTimeImmutable $dateOfEmployment;
    private Money $remuneration;
    private Money $addon;
    private DepartmentViewModel $department;

    private function __construct(
        EmployeeName $employeeName,
        DateTimeImmutable $dateOfEmployment,
        Money $remuneration,
        Money $addon,
        DepartmentViewModel $department,
    ) {
        $this->employeeName = $employeeName;
        $this->dateOfEmployment = $dateOfEmployment;
        $this->remuneration = $remuneration;
        $this->addon = $addon;
        $this->department = $department;
    }

    public static function fromScalars(
        string $firstName,
        string $lastName,
        string $dateOfEmployment,
        float $remunerationValue,
        string $remunerationCurrency,
        Money $addon,
        DepartmentViewModel $department,
    ): self {
        return new EmployeeViewModel(
            EmployeeName::fromScalars($firstName, $lastName),
            new DateTimeImmutable($dateOfEmployment),
            Money::of($remunerationValue, $remunerationCurrency),
            $addon,
            $department
        );
    }

    public function firstName(): string
    {
        return $this->employeeName->firstName();
    }

    public function lastName(): string
    {
        return $this->employeeName->lastName();
    }

    public function remuneration(): Money
    {
        return $this->remuneration;
    }

    public function salaryAddonAmount(): Money
    {
        return $this->addon;
    }

    public function totalRemuneration(): Money
    {
        return $this->remuneration->plus($this->addon);
    }

    public function dateOfEmployment(): DateTimeImmutable
    {
        return $this->dateOfEmployment;
    }

    public function departmentName(): string
    {
        return $this->department->name();
    }

    public function salaryAddonTypeName(): string
    {
        return $this->department->salaryAddonTypeName();
    }
}
