<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623111918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE salle_occupation_salle (salle_id INT NOT NULL, occupation_salle_id INT NOT NULL, INDEX IDX_D085E18BDC304035 (salle_id), INDEX IDX_D085E18BBAD50194 (occupation_salle_id), PRIMARY KEY(salle_id, occupation_salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salle_occupation_salle ADD CONSTRAINT FK_D085E18BDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_occupation_salle ADD CONSTRAINT FK_D085E18BBAD50194 FOREIGN KEY (occupation_salle_id) REFERENCES occupation_salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CBAD50194');
        $this->addSql('DROP INDEX IDX_4E977E5CBAD50194 ON salle');
        $this->addSql('ALTER TABLE salle DROP occupation_salle_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE salle_occupation_salle');
        $this->addSql('ALTER TABLE salle ADD occupation_salle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CBAD50194 FOREIGN KEY (occupation_salle_id) REFERENCES occupation_salle (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4E977E5CBAD50194 ON salle (occupation_salle_id)');
    }
}
