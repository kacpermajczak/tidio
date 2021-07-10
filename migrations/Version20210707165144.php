<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210707165144 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            "
            CREATE TABLE `departments` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(45) NOT NULL DEFAULT '',
              `salary_addon_type` enum('fixed','percentage') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              `salary_addon_value` int DEFAULT NULL,
              `salary_addon_currency` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'USD'  COMMENT 'ISO 4217',
              `salary_addon_percentage` float DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
        "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE `departments`;");
    }
}
