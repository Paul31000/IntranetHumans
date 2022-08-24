<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701092830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_questionnaire (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE remplissage_champ ADD user_questionnaire_id INT NOT NULL, DROP pseudo');
        $this->addSql('ALTER TABLE remplissage_champ ADD CONSTRAINT FK_690FB6F2B312AA22 FOREIGN KEY (user_questionnaire_id) REFERENCES user_questionnaire (id)');
        $this->addSql('CREATE INDEX IDX_690FB6F2B312AA22 ON remplissage_champ (user_questionnaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remplissage_champ DROP FOREIGN KEY FK_690FB6F2B312AA22');
        $this->addSql('DROP TABLE user_questionnaire');
        $this->addSql('DROP INDEX IDX_690FB6F2B312AA22 ON remplissage_champ');
        $this->addSql('ALTER TABLE remplissage_champ ADD pseudo VARCHAR(255) NOT NULL, DROP user_questionnaire_id');
    }
}
