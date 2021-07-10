<?php

declare(strict_types=1);

namespace App\Application\PaymentReport\Department;

//view model
use App\Application\PaymentReport\SalaryAddon\SalaryAddonTypeName;
use App\Domain\SalaryAddonType;
use Assert\Assert;

final class DepartmentViewModel
{
    private DepartmentName $departmentName;
    private SalaryAddonTypeName $salaryAddonTypeName;

    private function __construct(DepartmentName $departmentName, SalaryAddonTypeName $salaryAddonTypeName)
    {
        $this->departmentName = $departmentName;
        $this->salaryAddonTypeName = $salaryAddonTypeName;
    }

    public static function fromScalars(string $name, string $addonType): self
    {
        Assert::that($addonType)->inArray(SalaryAddonType::toArray());

        return new self(
            DepartmentName::fromString($name),
            SalaryAddonTypeName::fromString($addonType),
        );
    }

    public function name(): string
    {
        return $this->departmentName->asString();
    }

    public function salaryAddonTypeName(): string
    {
        return $this->salaryAddonTypeName->asString();
    }
}
