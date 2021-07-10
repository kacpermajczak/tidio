<?php

declare(strict_types=1);

namespace App\Application\PaymentReport;

final class ReportSorter implements ReportSorterInterface
{
    private array $sortMapping = [
        ReportSort::FIRST_NAME          => ReportRow::FIRST_NAME,
        ReportSort::LAST_NAME           => ReportRow::LAST_NAME,
        ReportSort::DEPARTMENT          => ReportRow::DEPARTMENT,
        ReportSort::REMUNERATION        => ReportRow::REMUNERATION,
        ReportSort::SALARY_ADDON_AMOUNT => ReportRow::SALARY_ADDON_AMOUNT,
        ReportSort::SALARY_ADDON_TYPE   => ReportRow::SALARY_ADDON_TYPE,
        ReportSort::TOTAL_REMUNERATION  => ReportRow::TOTAL_REMUNERATION,
    ];

    public function sort(PaymentReport $paymentReport, ReportSort $reportSort): array
    {
        $array = $paymentReport->asArray();

        if ($reportSort->key() === null) {
            return $array;
        }

        usort($array, $this->sortMultiDimensional($this->sortMapping[$reportSort->key()]));

        return $array;
    }

    private function sortMultiDimensional($key): \Closure
    {
        return static function ($a, $b) use ($key) {
            return strnatcmp($b[$key], $a[$key]);
        };
    }
}
