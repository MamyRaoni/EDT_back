<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104121823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matieres_classes (matieres_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_A60876B782350831 (matieres_id), INDEX IDX_A60876B79E225B24 (classes_id), PRIMARY KEY(matieres_id, classes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matieres_classes ADD CONSTRAINT FK_A60876B782350831 FOREIGN KEY (matieres_id) REFERENCES matieres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matieres_classes ADD CONSTRAINT FK_A60876B79E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matieres DROP FOREIGN KEY FK_8D9773D28F5EA509');
        $this->addSql('DROP INDEX IDX_8D9773D28F5EA509 ON matieres');
        $this->addSql('ALTER TABLE matieres DROP classe_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matieres_classes DROP FOREIGN KEY FK_A60876B782350831');
        $this->addSql('ALTER TABLE matieres_classes DROP FOREIGN KEY FK_A60876B79E225B24');
        $this->addSql('DROP TABLE matieres_classes');
        $this->addSql('ALTER TABLE matieres ADD classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matieres ADD CONSTRAINT FK_8D9773D28F5EA509 FOREIGN KEY (classe_id) REFERENCES classes (id)');
        $this->addSql('CREATE INDEX IDX_8D9773D28F5EA509 ON matieres (classe_id)');
    }
}
