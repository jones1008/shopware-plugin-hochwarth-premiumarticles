<?php declare(strict_types=1);

namespace HochwarthPremiumArticles\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1591361713PremiumArticleSalesChannel extends MigrationStep
{
    private const TABLENAME = 'hochwarth_premium_article_sales_channel';

    public function getCreationTimestamp(): int
    {
        return 1591361713;
    }

    public function update(Connection $connection): void
    {
        $sql = '
            CREATE TABLE `' . self::TABLENAME . '` (
                `premium_article_id` BINARY(16) NOT NULL,
                `sales_channel_id` BINARY(16) NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`premium_article_id`,`sales_channel_id`),
                KEY `fk.' . self::TABLENAME . '.premium_article_id` (`premium_article_id`),
                KEY `fk.' . self::TABLENAME . '.sales_channel_id` (`sales_channel_id`),
                CONSTRAINT `fk.' . self::TABLENAME . '.premium_article_id` FOREIGN KEY (`premium_article_id`) REFERENCES `hochwarth_premium_article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk.' . self::TABLENAME . '.sales_channel_id` FOREIGN KEY (`sales_channel_id`) REFERENCES `sales_channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ';
        $connection->executeUpdate($sql);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
