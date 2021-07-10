<?php

declare(strict_types=1);

namespace App\Application\PaymentReport;

interface ReportGeneratorInterface
{
    public function generate(ReportFilter $filters, ReportSort $sort): array;
}
