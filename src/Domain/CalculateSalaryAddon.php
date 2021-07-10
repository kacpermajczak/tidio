<?php

declare(strict_types=1);

namespace App\Domain;

use App\SharedKernel\Mapping;
use Assert\Assert;

//command
final class CalculateSalaryAddon
{
    use Mapping;

    private string $addonType;
    private ?float $addonAmount;
    private ?string $addonCurrency;
    private ?float $addonPercentage;
    private \DateTimeImmutable $dateOfEmployment;
    private float $baseOfRemunerationValue;
    private string $baseOfRemunerationCurrency;
    private \DateTimeImmutable $now;

    private function __construct(
        string $addonType,
        ?float $addonAmount,
        ?string $addonCurrency,
        ?float $addonPercentage,
        \DateTimeImmutable $dateOfEmployment,
        float $baseOfRemunerationValue,
        string $baseOfRemunerationCurrency,
        \DateTimeImmutable $now
    ) {
        $this->addonType = $addonType;
        $this->addonAmount = $addonAmount;
        $this->addonCurrency = $addonCurrency;
        $this->addonPercentage = $addonPercentage;
        $this->dateOfEmployment = $dateOfEmployment;
        $this->baseOfRemunerationValue = $baseOfRemunerationValue;
        $this->baseOfRemunerationCurrency = $baseOfRemunerationCurrency;
        $this->now = $now;
    }

    public static function fromArray(array $array, \DateTimeImmutable $now): self
    {
        Assert::that($array)->keyExists('salary_addon_type');
        Assert::that($array['salary_addon_type'])->inArray(SalaryAddonType::toArray());
        Assert::that($array)->keyExists('salary_addon_value');
        Assert::that($array['salary_addon_value'])->nullOr()->numeric();
        Assert::that($array)->keyExists('salary_addon_currency');
        Assert::that($array['salary_addon_currency'])->nullOr()->string()->length(3);
        Assert::that($array)->keyExists('salary_addon_percentage');
        Assert::that($array['salary_addon_percentage'])->nullOr()->numeric();
        Assert::that($array)->keyExists('date_of_employment');
        Assert::that($array['date_of_employment'])->date('Y-m-d');
        Assert::that($array)->keyExists('base_of_remuneration_value');
        Assert::that($array['base_of_remuneration_value'])->numeric();
        Assert::that($array)->keyExists('base_of_remuneration_currency');
        Assert::that($array['base_of_remuneration_currency'])->string()->length(3);

        return new self(
            self::asString($array, 'salary_addon_type'),
            self::asFloatOrNull($array, 'salary_addon_value'),
            self::asStringOrNull($array, 'salary_addon_currency'),
            self::asFloatOrNull($array, 'salary_addon_percentage') / 100,
            \DateTimeImmutable::createFromFormat('Y-m-d', $array['date_of_employment']),
            self::asFloat($array, 'base_of_remuneration_value'),
            self::asString($array, 'base_of_remuneration_currency'),
            $now
        );
    }

    public function getAddonType(): string
    {
        return $this->addonType;
    }

    public function getAddonAmount(): ?float
    {
        return $this->addonAmount;
    }

    public function getAddonCurrency(): ?string
    {
        return $this->addonCurrency;
    }

    public function getAddonPercentage(): ?float
    {
        return $this->addonPercentage;
    }

    public function getDateOfEmployment(): \DateTimeImmutable
    {
        return $this->dateOfEmployment;
    }

    public function getBaseOfRemunerationValue(): float
    {
        return $this->baseOfRemunerationValue;
    }

    public function getBaseOfRemunerationCurrency(): string
    {
        return $this->baseOfRemunerationCurrency;
    }

    public function getCurrentTime(): \DateTimeImmutable
    {
        return $this->now;
    }
}
