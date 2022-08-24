<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728152339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE occupation_salle ADD employe_occupant_id INT NOT NULL, DROP nom_occupant');
        $this->addSql('ALTER TABLE occupation_salle ADD CONSTRAINT FK_426987CA62383E2C FOREIGN KEY (employe_occupant_id) REFERENCES employee_information (id)');
        $this->addSql('CREATE INDEX IDX_426987CA62383E2C ON occupation_salle (employe_occupant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE occupation_salle DROP FOREIGN KEY FK_426987CA62383E2C');
        $this->addSql('DROP INDEX IDX_426987CA62383E2C ON occupation_salle');
        $this->addSql('ALTER TABLE occupation_salle ADD nom_occupant VARCHAR(255) NOT NULL, DROP employe_occupant_id');
    }
}
