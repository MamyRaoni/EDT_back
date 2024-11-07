<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107073744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emploi_du_temps (id INT AUTO_INCREMENT NOT NULL, classe VARCHAR(255) NOT NULL, tableau LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matieres DROP FOREIGN KEY FK_8D9773D2BAB22EE9');
        $this->addSql('ALTER TABLE matieres ADD CONSTRAINT FK_8D9773D2BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeurs (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE emploi_du_temps');
        $this->addSql('ALTER TABLE matieres DROP FOREIGN KEY FK_8D9773D2BAB22EE9');
        $this->addSql('ALTER TABLE matieres ADD CONSTRAINT FK_8D9773D2BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeurs (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
