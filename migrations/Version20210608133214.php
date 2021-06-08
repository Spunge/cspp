<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210608133214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corporate_bond_security CHANGE issuer_id issuer_id INT DEFAULT NULL, CHANGE country_id country_id INT DEFAULT NULL, CHANGE isin isin VARCHAR(12) DEFAULT NULL, CHANGE maturity_date maturity_date DATE DEFAULT NULL, CHANGE coupon_rate coupon_rate DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corporate_bond_security CHANGE issuer_id issuer_id INT NOT NULL, CHANGE country_id country_id INT NOT NULL, CHANGE isin isin VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE maturity_date maturity_date DATE NOT NULL, CHANGE coupon_rate coupon_rate DOUBLE PRECISION NOT NULL');
    }
}
