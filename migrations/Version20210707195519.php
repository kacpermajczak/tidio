<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210707195519 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            "
            CREATE TABLE `employees` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `first_name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
              `last_name` varchar(45) NOT NULL DEFAULT '',
              `department_id` int unsigned NOT NULL,
              `date_of_employment` date NOT NULL,
              `base_of_remuneration_value` float NOT NULL,
              `base_of_remuneration_currency` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'USD' COMMENT 'ISO 4217',
              PRIMARY KEY (`id`),
              CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
        "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE `employees`;");
    }
}
