<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623094114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE occupation_salle (id INT AUTO_INCREMENT NOT NULL, creneau_pris DATE NOT NULL, creneau DATETIME NOT NULL, nom_occupant VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, occupation_salle_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, INDEX IDX_4E977E5CBAD50194 (occupation_salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CBAD50194 FOREIGN KEY (occupation_salle_id) REFERENCES occupation_salle (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CBAD50194');
        $this->addSql('DROP TABLE occupation_salle');
        $this->addSql('DROP TABLE salle');
    }
}
