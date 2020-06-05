<?php declare(strict_types=1);

namespace HochwarthPremiumArticles\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\InheritanceUpdaterTrait;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1590753097PremiumArticle extends MigrationStep
{
    use InheritanceUpdaterTrait;

    private const TABLENAME = 'hochwarth_premium_article';

    public function getCreationTimestamp(): int
    {
        return 1590753097;
    }

    public function update(Connection $connection): void
    {
        $sql = '
            CREATE TABLE `' . self::TABLENAME . '` (
                `id` BINARY(16) NOT NULL,
                `active` TINYINT(1) NOT NULL DEFAULT \'1\',
                `min_price` DOUBLE NULL,
                `product_id` BINARY(16) NULL,
                `product_version_id` BINARY(16) NULL,
                `automatic_add` TINYINT(1) NULL DEFAULT \'1\',
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`),
                KEY `fk.' . self::TABLENAME . '.product_id` (`product_id`,`product_version_id`),
                CONSTRAINT `fk.' . self::TABLENAME . '.product_id` FOREIGN KEY (`product_id`,`product_version_id`) REFERENCES `product` (`id`,`version_id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ';
        $connection->executeUpdate($sql);
        $this->updateInheritance($connection, 'product', 'premiumArticles');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
