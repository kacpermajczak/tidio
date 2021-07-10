<?php

declare(strict_types=1);

namespace App\Application\PaymentReport;

final class ReportGenerator implements ReportGeneratorInterface
{
    private ReportRepository $reportRepository;
    private ReportSorterInterface $reportSorter;

    public function __construct(ReportRepository $reportRepository, ReportSorterInterface $reportSorter)
    {
        $this->reportRepository = $reportRepository;
        $this->reportSorter = $reportSorter;
    }

    public function generate(ReportFilter $filters, ReportSort $sort): array
    {
        $report = $this->reportRepository->getPaymentReport($filters);

        return $this->reportSorter->sort($report, $sort);
    }
}
