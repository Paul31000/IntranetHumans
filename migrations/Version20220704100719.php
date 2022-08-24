<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704100719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remplissage_champ DROP FOREIGN KEY FK_690FB6F2B312AA22');
        $this->addSql('CREATE TABLE remplissage_questionnaire (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, valeur LONGTEXT NOT NULL, pseudo VARCHAR(255) NOT NULL, INDEX IDX_2EE8B38BCE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE remplissage_questionnaire ADD CONSTRAINT FK_2EE8B38BCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('DROP TABLE remplissage_champ');
        $this->addSql('DROP TABLE user_questionnaire');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE remplissage_champ (id INT AUTO_INCREMENT NOT NULL, champ_id INT DEFAULT NULL, user_questionnaire_id INT NOT NULL, valeur LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_690FB6F2B312AA22 (user_questionnaire_id), INDEX IDX_690FB6F2D32AA90E (champ_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_questionnaire (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE remplissage_champ ADD CONSTRAINT FK_690FB6F2B312AA22 FOREIGN KEY (user_questionnaire_id) REFERENCES user_questionnaire (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE remplissage_champ ADD CONSTRAINT FK_690FB6F2D32AA90E FOREIGN KEY (champ_id) REFERENCES champ (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE remplissage_questionnaire');
    }
}
