<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104103134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, parcour_id INT DEFAULT NULL, mention_id INT DEFAULT NULL, nombre_eleve VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2ED7EC5B3E9C81 (niveau_id), INDEX IDX_2ED7EC59A561E99 (parcour_id), INDEX IDX_2ED7EC57A4147F0 (mention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contraintes (id INT AUTO_INCREMENT NOT NULL, professeur_id INT DEFAULT NULL, semaine VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', dosponibilite LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_4B1C2C6DBAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matieres (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, volume_horaire VARCHAR(255) NOT NULL, volume_horaire_restant VARCHAR(255) NOT NULL, semestre VARCHAR(255) NOT NULL, activation TINYINT(1) NOT NULL, INDEX IDX_8D9773D28F5EA509 (classe_id), INDEX IDX_8D9773D2BAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mentions (id INT AUTO_INCREMENT NOT NULL, libelle_mention VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveaux (id INT AUTO_INCREMENT NOT NULL, niveau VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL, contact VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salles (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(100) NOT NULL, capacite VARCHAR(255) NOT NULL, disponibilite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC5B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveaux (id)');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC59A561E99 FOREIGN KEY (parcour_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC57A4147F0 FOREIGN KEY (mention_id) REFERENCES mentions (id)');
        $this->addSql('ALTER TABLE contraintes ADD CONSTRAINT FK_4B1C2C6DBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeurs (id)');
        $this->addSql('ALTER TABLE matieres ADD CONSTRAINT FK_8D9773D28F5EA509 FOREIGN KEY (classe_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE matieres ADD CONSTRAINT FK_8D9773D2BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeurs (id)');
        $this->addSql('ALTER TABLE contrainte DROP FOREIGN KEY FK_17925A70755C5E8E');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE contrainte');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE mention');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE salle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, nombre_eleve VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contrainte (id INT AUTO_INCREMENT NOT NULL, id_prof_id INT DEFAULT NULL, jour DATE NOT NULL, timeslot LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', INDEX IDX_17925A70755C5E8E (id_prof_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, volume_horaire VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, volume_horaire_restant VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, semestre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, activation TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE mention (id INT AUTO_INCREMENT NOT NULL, libelle_mention VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, niveau VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, grade VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sexe VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, contact VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, capacite VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, disponibilite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contrainte ADD CONSTRAINT FK_17925A70755C5E8E FOREIGN KEY (id_prof_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC5B3E9C81');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC59A561E99');
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC57A4147F0');
        $this->addSql('ALTER TABLE contraintes DROP FOREIGN KEY FK_4B1C2C6DBAB22EE9');
        $this->addSql('ALTER TABLE matieres DROP FOREIGN KEY FK_8D9773D28F5EA509');
        $this->addSql('ALTER TABLE matieres DROP FOREIGN KEY FK_8D9773D2BAB22EE9');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE contraintes');
        $this->addSql('DROP TABLE matieres');
        $this->addSql('DROP TABLE mentions');
        $this->addSql('DROP TABLE niveaux');
        $this->addSql('DROP TABLE professeurs');
        $this->addSql('DROP TABLE salles');
    }
}
