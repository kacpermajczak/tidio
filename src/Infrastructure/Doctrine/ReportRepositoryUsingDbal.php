<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Application\PaymentReport\Department\DepartmentViewModel;
use App\Application\PaymentReport\Employee\EmployeeViewModel;
use App\Application\PaymentReport\PaymentReport;
use App\Application\PaymentReport\ReportFilter;
use App\Application\PaymentReport\ReportRepository;
use App\Application\PaymentReport\ReportRow;
use App\Domain\CalculateSalaryAddon;
use App\Domain\SalaryAddonFactory;
use App\SharedKernel\Mapping;
use Brick\Money\Money;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

final class ReportRepositoryUsingDbal implements ReportRepository
{
    use Mapping;

    private Connection $connection;
    private SalaryAddonFactory $salaryAddonFactory;

    private array $mapFilters = [
        'first_name'      => 'e.first_name',
        'last_name'       => 'e.last_name',
        'department_name' => 'd.name',
    ];


    public function __construct(
        Connection $connection,
        SalaryAddonFactory $salaryAddonFactory,
    ) {
        $this->connection = $connection;
        $this->salaryAddonFactory = $salaryAddonFactory;
    }

    public function getPaymentReport(ReportFilter $filters): PaymentReport
    {
        $qb = $this->connection->createQueryBuilder()->select(
            'e.first_name as first_name',
            'e.last_name as last_name',
            'e.date_of_employment as date_of_employment',
            'e.base_of_remuneration_value as base_of_remuneration_value',
            'e.base_of_remuneration_currency as base_of_remuneration_currency',
            'd.name as department_name',
            'd.salary_addon_type as salary_addon_type',
            'd.salary_addon_value as salary_addon_value',
            'd.salary_addon_currency as salary_addon_currency',
            'd.salary_addon_percentage as salary_addon_percentage',
        )
            ->from('employees', 'e')
            ->innerJoin('e', 'departments', 'd', 'e.department_id = d.id');

        $this->addFilters($filters, $qb);

        $dbResult = $qb->execute()->fetchAllAssociative();

        $paymentReport = PaymentReport::createEmpty();
        foreach ($dbResult as $row) {
            $salaryAddonCommand = CalculateSalaryAddon::fromArray($row);
            $salaryAddon = $this->salaryAddonFactory->create($salaryAddonCommand);
            $salaryAddonValue = $salaryAddon->calculate($salaryAddonCommand);

            $department = $this->createDepartment($row);
            $employee = $this->createEmployee($row, $salaryAddonValue, $department);

            $paymentReport->add(ReportRow::create($employee));
        }

        return $paymentReport;
    }

    private function createDepartment(array $item): DepartmentViewModel
    {
        return DepartmentViewModel::fromScalars(
            self::asString($item, 'department_name'),
            self::asString($item, 'salary_addon_type'),
        );
    }

    private function createEmployee(array $item, Money $addon, DepartmentViewModel $department): EmployeeViewModel
    {
        return EmployeeViewModel::fromScalars(
            self::asString($item, 'first_name'),
            self::asString($item, 'last_name'),
            self::asString($item, 'date_of_employment'),
            self::asFloatOrNull($item, 'base_of_remuneration_value'),
            self::asString($item, 'base_of_remuneration_currency'),
            $addon,
            $department,
        );
    }

    private function addFilters(ReportFilter $reportFilters, QueryBuilder $qb): void
    {
        if ($reportFilters->key() !== null && $reportFilters->value() !== null) {
            $qb->andWhere($qb->expr()->eq($this->mapFilters[$reportFilters->key()], $qb->createNamedParameter($reportFilters->value())));
        }
    }
}
