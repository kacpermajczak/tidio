<?php

declare(strict_types=1);

namespace App\Application\PaymentReport;

use Assert\Assert;

final class PaymentReport
{
    /** @var array<ReportRow> */
    private array $reportRows;

    private function __construct(array $reportRows)
    {
        Assert::thatAll($reportRows)->isInstanceOf(ReportRow::class);
        $this->reportRows = $reportRows;
    }

    public static function createEmpty(): self
    {
        return new self([]);
    }

    public static function fromArray(array $reportRows): self
    {
        return new self($reportRows);
    }

    public function add(ReportRow $reportRow): void
    {
        $this->reportRows[] = $reportRow;
    }

    public function asArray(): array
    {
        $result = [];

        foreach ($this->reportRows as $reportRow) {
            $result[] = $reportRow->asArray();
        }

        return $result;
    }
}
