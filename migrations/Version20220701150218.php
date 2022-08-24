<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701150218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contenu');
        $this->addSql('ALTER TABLE champ ADD nom_technique VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE remplissage_champ ADD valeur VARCHAR(1000) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, remplissage_champ_id INT DEFAULT NULL, valeur VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_89C2003FF2217648 (remplissage_champ_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003FF2217648 FOREIGN KEY (remplissage_champ_id) REFERENCES remplissage_champ (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE champ DROP nom_technique');
        $this->addSql('ALTER TABLE remplissage_champ DROP valeur');
    }
}
