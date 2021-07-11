<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Doctrine;

use App\Application\PaymentReport\ReportFilter;
use App\Domain\SalaryAddonFactory;
use App\Infrastructure\Doctrine\ReportRepositoryUsingDbal;
use App\Tests\FakeClock;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class ReportRepositoryUsingDbalTest extends KernelTestCase
{
    private ?ReportRepositoryUsingDbal $reportRepository;
    private ?Connection $connection;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $clock = new FakeClock();
        $clock->setCurrentDate('2021-01-01');

        $this->connection = $kernel->getContainer()->get('doctrine.dbal.default_connection');
        $this->reportRepository = new ReportRepositoryUsingDbal($this->connection, new SalaryAddonFactory($clock));

        $this->seedDepartments();
        $this->seedEmployees();
    }

    /**
     * @dataProvider data
     */
    public function test_generates_payment_report(?string $key, ?string $value, array $result): void
    {
        // Given
        $reportFilters = ReportFilter::create($key, $value);

        // When
        $report = $this->reportRepository->getPaymentReport($reportFilters);

        // Then
        self::assertEquals($result, $report->asArray());
    }

    public function data(): array
    {
        return [
            'simply report'                 => [
                'key'    => null,
                'value'  => null,
                'result' => $this->report(),
            ],
            'filter department name report' => [
                'key'    => 'department_name',
                'value'  => 'Human Resources',
                'result' => $this->filteredByDepartmentReport(),
            ],
            'filter first name name report' => [
                'key'    => 'first_name',
                'value'  => 'Adam',
                'result' => $this->filteredByFirstNameReport(),
            ],
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->connection->executeQuery('DELETE FROM departments WHERE 1');
        $this->connection->executeQuery('DELETE FROM employees WHERE 1');
    }

    private function seedDepartments(): void
    {
        $this->connection->insert(
            'departments',
            [
                'id'                      => 1,
                'name'                    => 'Human Resources',
                'salary_addon_type'       => 'fixed',
                'salary_addon_value'      => '100',
                'salary_addon_currency'   => 'USD',
                'salary_addon_percentage' => null,
            ]
        );
        $this->connection->insert(
            'departments',
            [
                'id'                      => 2,
                'name'                    => 'Customer Service',
                'salary_addon_type'       => 'percent',
                'salary_addon_value'      => null,
                'salary_addon_currency'   => null,
                'salary_addon_percentage' => '10',
            ]
        );
    }

    private function seedEmployees(): void
    {
        $this->connection->insert(
            'employees',
            [
                'id'                            => '1',
                'first_name'                    => 'Adam',
                'last_name'                     => 'Kowalski',
                'department_id'                 => 1,
                'date_of_employment'            => '2006-01-01',
                'base_of_remuneration_value'    => '1000',
                'base_of_remuneration_currency' => 'USD',
            ]
        );
        $this->connection->insert(
            'employees',
            [
                'id'                            => '2',
                'first_name'                    => 'Ania',
                'last_name'                     => 'Nowak',
                'department_id'                 => 2,
                'date_of_employment'            => '2016-01-01',
                'base_of_remuneration_value'    => '1100',
                'base_of_remuneration_currency' => 'USD',
            ]
        );
        $this->connection->insert(
            'employees',
            [
                'id'                            => '3',
                'first_name'                    => 'Raymond',
                'last_name'                     => 'Ainsworth',
                'department_id'                 => 2,
                'date_of_employment'            => '2018-01-01',
                'base_of_remuneration_value'    => '1740',
                'base_of_remuneration_currency' => 'USD',
            ]
        );
        $this->connection->insert(
            'employees',
            [
                'id'                            => '4',
                'first_name'                    => 'Silvia',
                'last_name'                     => 'Wade',
                'department_id'                 => 2,
                'date_of_employment'            => '2011-01-01',
                'base_of_remuneration_value'    => '1920',
                'base_of_remuneration_currency' => 'USD',
            ]
        );
        $this->connection->insert(
            'employees',
            [
                'id'                            => '5',
                'first_name'                    => 'Adam',
                'last_name'                     => 'Wade',
                'department_id'                 => 2,
                'date_of_employment'            => '2013-01-01',
                'base_of_remuneration_value'    => '1940',
                'base_of_remuneration_currency' => 'USD',
            ]
        );
    }

    private function report(): array
    {
        return [
            [
                "Imię"                                   => "Adam",
                "Nazwisko"                               => "Kowalski",
                "Dział"                                  => "Human Resources",
                "Podstawa Wynagrodzenia (kwota)"         => "$1,000.00",
                "Dodatek do podstawy (kwota)"            => "$1,000.00",
                "Typ dodatku (typ % lub stały)"          => "fixed",
                "Wynagrodzenie wraz z dodatkiem (kwota)" => "$2,000.00",
            ],
            [
                "Imię"                                   => "Ania",
                "Nazwisko"                               => "Nowak",
                "Dział"                                  => "Customer Service",
                "Podstawa Wynagrodzenia (kwota)"         => "$1,100.00",
                "Dodatek do podstawy (kwota)"            => "$110.00",
                "Typ dodatku (typ % lub stały)"          => "percent",
                "Wynagrodzenie wraz z dodatkiem (kwota)" => "$1,210.00",
            ],
            [
                "Imię"                                   => "Raymond",
                "Nazwisko"                               => "Ainsworth",
                "Dział"                                  => "Customer Service",
                "Podstawa Wynagrodzenia (kwota)"         => "$1,740.00",
                "Dodatek do podstawy (kwota)"            => "$174.00",
                "Typ dodatku (typ % lub stały)"          => "percent",
                "Wynagrodzenie wraz z dodatkiem (kwota)" => "$1,914.00",
            ],
            [
                "Imię"                                   => "Silvia",
                "Nazwisko"                               => "Wade",
                "Dział"                                  => "Customer Service",
                "Podstawa Wynagrodzenia (kwota)"         => "$1,920.00",
                "Dodatek do podstawy (kwota)"            => "$192.00",
                "Typ dodatku (typ % lub stały)"          => "percent",
                "Wynagrodzenie wraz z dodatkiem (kwota)" => "$2,112.00",
            ],
            [
                "Imię"                                   => "Adam",
                "Nazwisko"                               => "Wade",
                "Dział"                                  => "Customer Service",
                "Podstawa Wynagrodzenia (kwota)"         => "$1,940.00",
                "Dodatek do podstawy (kwota)"            => "$194.00",
                "Typ dodatku (typ % lub stały)"          => "percent",
                "Wynagrodzenie wraz z dodatkiem (kwota)" => "$2,134.00",
            ],
        ];
    }

    private function filteredByDepartmentReport(): array
    {
        return [
            [
                "Imię"                                   => "Adam",
                "Nazwisko"                               => "Kowalski",
                "Dział"                                  => "Human Resources",
                "Podstawa Wynagrodzenia (kwota)"         => "$1,000.00",
                "Dodatek do podstawy (kwota)"            => "$1,000.00",
                "Typ dodatku (typ % lub stały)"          => "fixed",
                "Wynagrodzenie wraz z dodatkiem (kwota)" => "$2,000.00",
            ]
        ];
    }

    private function filteredByFirstNameReport(): array
    {
        return [
            [
                "Imię"                                   => "Adam",
                "Nazwisko"                               => "Kowalski",
                "Dział"                                  => "Human Resources",
                "Podstawa Wynagrodzenia (kwota)"         => "$1,000.00",
                "Dodatek do podstawy (kwota)"            => "$1,000.00",
                "Typ dodatku (typ % lub stały)"          => "fixed",
                "Wynagrodzenie wraz z dodatkiem (kwota)" => "$2,000.00",
            ],
            [
                "Imię"                                   => "Adam",
                "Nazwisko"                               => "Wade",
                "Dział"                                  => "Customer Service",
                "Podstawa Wynagrodzenia (kwota)"         => "$1,940.00",
                "Dodatek do podstawy (kwota)"            => "$194.00",
                "Typ dodatku (typ % lub stały)"          => "percent",
                "Wynagrodzenie wraz z dodatkiem (kwota)" => "$2,134.00",
            ],
        ];
    }
}
