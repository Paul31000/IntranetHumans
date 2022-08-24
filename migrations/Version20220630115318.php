<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630115318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE champ (id INT AUTO_INCREMENT NOT NULL, remplissage_champ_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, ordre INT NOT NULL, INDEX IDX_2F61E0ADF2217648 (remplissage_champ_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, remplissage_champ_id INT DEFAULT NULL, valeur VARCHAR(1000) NOT NULL, INDEX IDX_89C2003FF2217648 (remplissage_champ_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remplissage_champ (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE champ ADD CONSTRAINT FK_2F61E0ADF2217648 FOREIGN KEY (remplissage_champ_id) REFERENCES remplissage_champ (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003FF2217648 FOREIGN KEY (remplissage_champ_id) REFERENCES remplissage_champ (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champ DROP FOREIGN KEY FK_2F61E0ADF2217648');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003FF2217648');
        $this->addSql('DROP TABLE champ');
        $this->addSql('DROP TABLE contenu');
        $this->addSql('DROP TABLE remplissage_champ');
    }
}
