<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309215752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE voucher (id BIGINT AUTO_INCREMENT NOT NULL, code VARCHAR(100) NOT NULL, discount DOUBLE PRECISION NOT NULL, isClaimed TINYINT(1) NOT NULL, isPercentage TINYINT(1) NOT NULL, orderId BIGINT DEFAULT NULL, userId BIGINT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME DEFAULT NULL, extraData TEXT DEFAULT NULL, INDEX idx_order_user (userId), UNIQUE INDEX code_unique (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE voucher');
    }
}
