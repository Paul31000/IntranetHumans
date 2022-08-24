<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220506115348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lien_page_categorie (lien_page_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_A93464B4C35787A9 (lien_page_id), INDEX IDX_A93464B4BCF5E72D (categorie_id), PRIMARY KEY(lien_page_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lien_page_categorie ADD CONSTRAINT FK_A93464B4C35787A9 FOREIGN KEY (lien_page_id) REFERENCES lien_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lien_page_categorie ADD CONSTRAINT FK_A93464B4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lien_page DROP categorie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lien_page_categorie DROP FOREIGN KEY FK_A93464B4BCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE lien_page_categorie');
        $this->addSql('ALTER TABLE lien_page ADD categorie VARCHAR(255) NOT NULL');
    }
}
