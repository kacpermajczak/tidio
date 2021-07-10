<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Application\Application;
use App\Application\PaymentReport\ReportFilter;
use App\Application\PaymentReport\ReportSort;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ReportGenerator extends Command
{
    protected static $defaultName = 'report-generator';
    private Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'filter',
                null,
                InputArgument::OPTIONAL,
                sprintf('Column for filtering. Options: %s', implode(',', ReportFilter::$availableFilters))
            )
            ->addOption(
                'value',
                null,
                InputArgument::OPTIONAL,
                'Value for filtering.'
            )
            ->addOption(
                'sort',
                null,
                InputArgument::OPTIONAL,
                sprintf('Sort by: %s', implode(',', ReportSort::$availableSort))
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filters = ReportFilter::create($input->getOption('filter'), $input->getOption('value'));
        $sort = ReportSort::create($input->getOption('sort'));
        $report = $this->application->generatePaymentReport($filters, $sort);

        if (!empty($report)) {
            $table = new Table($output);
            $table
                ->setHeaders([array_keys($report[0])])
                ->setRows($report)
                ->render();
        }

        return Command::SUCCESS;
    }
}
