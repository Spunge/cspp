<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210607204244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE corporate_bond_security (id INT AUTO_INCREMENT NOT NULL, ncb VARCHAR(2) NOT NULL, isin VARCHAR(12) NOT NULL, issuer VARCHAR(255) NOT NULL, maturity_date DATE NOT NULL, coupon_rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE corporate_bond_security_import (corporate_bond_security_id INT NOT NULL, import_id INT NOT NULL, INDEX IDX_EB7FC63FE845BB9D (corporate_bond_security_id), INDEX IDX_EB7FC63FB6A263D9 (import_id), PRIMARY KEY(corporate_bond_security_id, import_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE import (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE corporate_bond_security_import ADD CONSTRAINT FK_EB7FC63FE845BB9D FOREIGN KEY (corporate_bond_security_id) REFERENCES corporate_bond_security (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE corporate_bond_security_import ADD CONSTRAINT FK_EB7FC63FB6A263D9 FOREIGN KEY (import_id) REFERENCES import (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corporate_bond_security_import DROP FOREIGN KEY FK_EB7FC63FE845BB9D');
        $this->addSql('ALTER TABLE corporate_bond_security_import DROP FOREIGN KEY FK_EB7FC63FB6A263D9');
        $this->addSql('DROP TABLE corporate_bond_security');
        $this->addSql('DROP TABLE corporate_bond_security_import');
        $this->addSql('DROP TABLE import');
    }
}
