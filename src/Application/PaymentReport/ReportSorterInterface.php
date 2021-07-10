<?php

declare(strict_types=1);

namespace App\Application\PaymentReport;

interface ReportSorterInterface
{
    public function sort(PaymentReport $paymentReport, ReportSort $reportSort): array;
}
