<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210608081611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corporate_bond_security ADD issuer_id INT NOT NULL, ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE corporate_bond_security ADD CONSTRAINT FK_66E294ABBB9D6FEE FOREIGN KEY (issuer_id) REFERENCES corporation (id)');
        $this->addSql('ALTER TABLE corporate_bond_security ADD CONSTRAINT FK_66E294ABF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_66E294ABBB9D6FEE ON corporate_bond_security (issuer_id)');
        $this->addSql('CREATE INDEX IDX_66E294ABF92F3E70 ON corporate_bond_security (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corporate_bond_security DROP FOREIGN KEY FK_66E294ABBB9D6FEE');
        $this->addSql('ALTER TABLE corporate_bond_security DROP FOREIGN KEY FK_66E294ABF92F3E70');
        $this->addSql('DROP INDEX IDX_66E294ABBB9D6FEE ON corporate_bond_security');
        $this->addSql('DROP INDEX IDX_66E294ABF92F3E70 ON corporate_bond_security');
        $this->addSql('ALTER TABLE corporate_bond_security DROP issuer_id, DROP country_id');
    }
}
