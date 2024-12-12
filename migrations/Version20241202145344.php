<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202145344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, nombre_eleve VARCHAR(255) NOT NULL, libelle_classe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contraintes (id INT AUTO_INCREMENT NOT NULL, professeur_id INT DEFAULT NULL, disponibilite LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', jour VARCHAR(255) NOT NULL, INDEX IDX_4B1C2C6DBAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emploi_du_temps (id INT AUTO_INCREMENT NOT NULL, classe VARCHAR(255) NOT NULL, tableau LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', semestre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matieres (id INT AUTO_INCREMENT NOT NULL, professeur_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, volume_horaire VARCHAR(255) NOT NULL, volume_horaire_restant VARCHAR(255) NOT NULL, semestre VARCHAR(255) NOT NULL, activation TINYINT(1) NOT NULL, INDEX IDX_8D9773D2BAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matieres_classes (matieres_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_A60876B782350831 (matieres_id), INDEX IDX_A60876B79E225B24 (classes_id), PRIMARY KEY(matieres_id, classes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mentions (id INT AUTO_INCREMENT NOT NULL, libelle_mention VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveaux (id INT AUTO_INCREMENT NOT NULL, niveau VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcours (id INT AUTO_INCREMENT NOT NULL, libelle_parcours VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL, contact VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salles (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(100) NOT NULL, capacite VARCHAR(255) NOT NULL, disponibilite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contraintes ADD CONSTRAINT FK_4B1C2C6DBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeurs (id)');
        $this->addSql('ALTER TABLE matieres ADD CONSTRAINT FK_8D9773D2BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeurs (id)');
        $this->addSql('ALTER TABLE matieres_classes ADD CONSTRAINT FK_A60876B782350831 FOREIGN KEY (matieres_id) REFERENCES matieres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matieres_classes ADD CONSTRAINT FK_A60876B79E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contraintes DROP FOREIGN KEY FK_4B1C2C6DBAB22EE9');
        $this->addSql('ALTER TABLE matieres DROP FOREIGN KEY FK_8D9773D2BAB22EE9');
        $this->addSql('ALTER TABLE matieres_classes DROP FOREIGN KEY FK_A60876B782350831');
        $this->addSql('ALTER TABLE matieres_classes DROP FOREIGN KEY FK_A60876B79E225B24');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE contraintes');
        $this->addSql('DROP TABLE emploi_du_temps');
        $this->addSql('DROP TABLE matieres');
        $this->addSql('DROP TABLE matieres_classes');
        $this->addSql('DROP TABLE mentions');
        $this->addSql('DROP TABLE niveaux');
        $this->addSql('DROP TABLE parcours');
        $this->addSql('DROP TABLE professeurs');
        $this->addSql('DROP TABLE salles');
    }
}
