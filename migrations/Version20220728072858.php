<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728072858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conge ADD employe_information_id INT NOT NULL, DROP employe');
        $this->addSql('ALTER TABLE conge ADD CONSTRAINT FK_2ED893485CFAD953 FOREIGN KEY (employe_information_id) REFERENCES employee_information (id)');
        $this->addSql('CREATE INDEX IDX_2ED893485CFAD953 ON conge (employe_information_id)');
        $this->addSql('ALTER TABLE employee_information ADD couleur_css VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conge DROP FOREIGN KEY FK_2ED893485CFAD953');
        $this->addSql('DROP INDEX IDX_2ED893485CFAD953 ON conge');
        $this->addSql('ALTER TABLE conge ADD employe VARCHAR(255) NOT NULL, DROP employe_information_id');
        $this->addSql('ALTER TABLE employee_information DROP couleur_css');
    }
}
