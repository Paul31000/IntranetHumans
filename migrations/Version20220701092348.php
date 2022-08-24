<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701092348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remplissage_champ ADD champ_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE remplissage_champ ADD CONSTRAINT FK_690FB6F2D32AA90E FOREIGN KEY (champ_id) REFERENCES champ (id)');
        $this->addSql('CREATE INDEX IDX_690FB6F2D32AA90E ON remplissage_champ (champ_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remplissage_champ DROP FOREIGN KEY FK_690FB6F2D32AA90E');
        $this->addSql('DROP INDEX IDX_690FB6F2D32AA90E ON remplissage_champ');
        $this->addSql('ALTER TABLE remplissage_champ DROP champ_id');
    }
}
