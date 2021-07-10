<?php

declare(strict_types=1);

namespace App\Application\PaymentReport;

interface ReportRepository
{
    public function getPaymentReport(ReportFilter $filters): PaymentReport;
}
