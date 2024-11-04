<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104192859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC59A561E99');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC5B3E9C81');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC57A4147F0');
        $this->addSql('DROP INDEX IDX_2ED7EC59A561E99 ON classes');
        $this->addSql('DROP INDEX IDX_2ED7EC57A4147F0 ON classes');
        $this->addSql('DROP INDEX IDX_2ED7EC5B3E9C81 ON classes');
        $this->addSql('ALTER TABLE classes ADD libelle_classe VARCHAR(255) NOT NULL, DROP niveau_id, DROP parcour_id, DROP mention_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes ADD niveau_id INT DEFAULT NULL, ADD parcour_id INT DEFAULT NULL, ADD mention_id INT DEFAULT NULL, DROP libelle_classe');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC59A561E99 FOREIGN KEY (parcour_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC5B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveaux (id)');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC57A4147F0 FOREIGN KEY (mention_id) REFERENCES mentions (id)');
        $this->addSql('CREATE INDEX IDX_2ED7EC59A561E99 ON classes (parcour_id)');
        $this->addSql('CREATE INDEX IDX_2ED7EC57A4147F0 ON classes (mention_id)');
        $this->addSql('CREATE INDEX IDX_2ED7EC5B3E9C81 ON classes (niveau_id)');
    }
}
