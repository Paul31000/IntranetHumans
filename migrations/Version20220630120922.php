<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630120922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE champ ADD questionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE champ ADD CONSTRAINT FK_2F61E0ADCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('CREATE INDEX IDX_2F61E0ADCE07E8FF ON champ (questionnaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champ DROP FOREIGN KEY FK_2F61E0ADCE07E8FF');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP INDEX IDX_2F61E0ADCE07E8FF ON champ');
        $this->addSql('ALTER TABLE champ DROP questionnaire_id');
    }
}
