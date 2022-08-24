<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630154345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champ DROP FOREIGN KEY FK_2F61E0ADF2217648');
        $this->addSql('DROP INDEX IDX_2F61E0ADF2217648 ON champ');
        $this->addSql('ALTER TABLE champ DROP remplissage_champ_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champ ADD remplissage_champ_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE champ ADD CONSTRAINT FK_2F61E0ADF2217648 FOREIGN KEY (remplissage_champ_id) REFERENCES remplissage_champ (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2F61E0ADF2217648 ON champ (remplissage_champ_id)');
    }
}
