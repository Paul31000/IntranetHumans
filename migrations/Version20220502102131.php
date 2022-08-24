<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220502102131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, icone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_lien_page (page_id INT NOT NULL, lien_page_id INT NOT NULL, INDEX IDX_CC695E0FC4663E4 (page_id), INDEX IDX_CC695E0FC35787A9 (lien_page_id), PRIMARY KEY(page_id, lien_page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_lien_page ADD CONSTRAINT FK_CC695E0FC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_lien_page ADD CONSTRAINT FK_CC695E0FC35787A9 FOREIGN KEY (lien_page_id) REFERENCES lien_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lien_page DROP page');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_lien_page DROP FOREIGN KEY FK_CC695E0FC4663E4');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_lien_page');
        $this->addSql('ALTER TABLE lien_page ADD page VARCHAR(255) DEFAULT NULL');
    }
}
