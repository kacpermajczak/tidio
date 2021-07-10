<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\PaymentReport\ReportFilter;
use App\Application\PaymentReport\ReportGeneratorInterface;
use App\Application\PaymentReport\ReportSort;

//application facade
final class Application
{
    private ReportGeneratorInterface $reportGenerator;

    public function __construct(ReportGeneratorInterface $reportGenerator)
    {
        $this->reportGenerator = $reportGenerator;
    }

    public function generatePaymentReport(ReportFilter $filters, ReportSort $sort): array
    {
        return $this->reportGenerator->generate($filters, $sort);
    }
}
