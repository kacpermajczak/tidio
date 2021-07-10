<?php

declare(strict_types=1);

namespace App\Application\PaymentReport;

use Assert\Assert;

final class ReportSort
{
    public const FIRST_NAME = 'first_name';
    public const LAST_NAME = 'last_name';
    public const DEPARTMENT = 'department_name';
    public const REMUNERATION = 'base_of_remuneration';
    public const SALARY_ADDON_AMOUNT = 'addition_to_base';
    public const SALARY_ADDON_TYPE = 'add-on_type';
    public const TOTAL_REMUNERATION = 'salary_with_allowance';

    public static array $availableSort = [
        self::FIRST_NAME,
        self::LAST_NAME,
        self::DEPARTMENT,
        self::REMUNERATION,
        self::SALARY_ADDON_AMOUNT,
        self::SALARY_ADDON_TYPE,
        self::TOTAL_REMUNERATION,
    ];
    private ?string $sort;

    private function __construct(?string $sort)
    {
        Assert::that($sort)->nullOr()->inArray(self::$availableSort);

        $this->sort = $sort;
    }

    public static function create(?string $sort = null): self
    {
        return new self($sort);
    }

    public function key(): ?string
    {
        return $this->sort;
    }
}
