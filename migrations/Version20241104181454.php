<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104181454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes DROP INDEX UNIQ_2ED7EC5B3E9C81, ADD INDEX IDX_2ED7EC5B3E9C81 (niveau_id)');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC57A4147F0');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC59A561E99');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC5B3E9C81');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC57A4147F0 FOREIGN KEY (mention_id) REFERENCES mentions (id)');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC59A561E99 FOREIGN KEY (parcour_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC5B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveaux (id)');
        $this->addSql('ALTER TABLE matieres DROP FOREIGN KEY FK_8D9773D2BAB22EE9');
        $this->addSql('ALTER TABLE matieres ADD CONSTRAINT FK_8D9773D2BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeurs (id)');
        $this->addSql('ALTER TABLE matieres_classes DROP FOREIGN KEY FK_A60876B79E225B24');
        $this->addSql('ALTER TABLE matieres_classes DROP FOREIGN KEY FK_A60876B782350831');
        $this->addSql('ALTER TABLE matieres_classes ADD CONSTRAINT FK_A60876B79E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matieres_classes ADD CONSTRAINT FK_A60876B782350831 FOREIGN KEY (matieres_id) REFERENCES matieres (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes DROP INDEX IDX_2ED7EC5B3E9C81, ADD UNIQUE INDEX UNIQ_2ED7EC5B3E9C81 (niveau_id)');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC5B3E9C81');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC59A561E99');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC57A4147F0');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC5B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveaux (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC59A561E99 FOREIGN KEY (parcour_id) REFERENCES parcours (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC57A4147F0 FOREIGN KEY (mention_id) REFERENCES mentions (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matieres DROP FOREIGN KEY FK_8D9773D2BAB22EE9');
        $this->addSql('ALTER TABLE matieres ADD CONSTRAINT FK_8D9773D2BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeurs (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matieres_classes DROP FOREIGN KEY FK_A60876B782350831');
        $this->addSql('ALTER TABLE matieres_classes DROP FOREIGN KEY FK_A60876B79E225B24');
        $this->addSql('ALTER TABLE matieres_classes ADD CONSTRAINT FK_A60876B782350831 FOREIGN KEY (matieres_id) REFERENCES matieres (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matieres_classes ADD CONSTRAINT FK_A60876B79E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
