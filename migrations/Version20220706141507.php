<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706141507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_occupation_salle DROP FOREIGN KEY FK_D085E18BBAD50194');
        $this->addSql('ALTER TABLE salle_occupation_salle DROP FOREIGN KEY FK_D085E18BDC304035');
        $this->addSql('DROP TABLE occupation_salle');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE salle_occupation_salle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE occupation_salle (id INT AUTO_INCREMENT NOT NULL, creneau DATETIME NOT NULL, nom_occupant VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, fin_creneau DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, position VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE salle_occupation_salle (salle_id INT NOT NULL, occupation_salle_id INT NOT NULL, INDEX IDX_D085E18BBAD50194 (occupation_salle_id), INDEX IDX_D085E18BDC304035 (salle_id), PRIMARY KEY(salle_id, occupation_salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE salle_occupation_salle ADD CONSTRAINT FK_D085E18BBAD50194 FOREIGN KEY (occupation_salle_id) REFERENCES occupation_salle (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_occupation_salle ADD CONSTRAINT FK_D085E18BDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
