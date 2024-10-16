<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015182626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, nombre_eleve VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrainte (id INT AUTO_INCREMENT NOT NULL, id_prof_id INT DEFAULT NULL, jour DATE NOT NULL, timeslot LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_17925A70755C5E8E (id_prof_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, id_classe_id INT DEFAULT NULL, id_prof_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, volume_horaire VARCHAR(255) NOT NULL, volume_horaire_restant VARCHAR(255) NOT NULL, semestre VARCHAR(255) NOT NULL, activation TINYINT(1) NOT NULL, INDEX IDX_9014574AF6B192E (id_classe_id), INDEX IDX_9014574A755C5E8E (id_prof_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_parcours (matiere_id INT NOT NULL, parcours_id INT NOT NULL, INDEX IDX_2DD9465BF46CD258 (matiere_id), INDEX IDX_2DD9465B6E38C0DB (parcours_id), PRIMARY KEY(matiere_id, parcours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mention (id INT AUTO_INCREMENT NOT NULL, libelle_mention VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcours (id INT AUTO_INCREMENT NOT NULL, mention_id INT DEFAULT NULL, libelle_parcours VARCHAR(255) NOT NULL, INDEX IDX_99B1DEE37A4147F0 (mention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcours_classe (parcours_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_8127164A6E38C0DB (parcours_id), INDEX IDX_8127164A8F5EA509 (classe_id), PRIMARY KEY(parcours_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL, contact VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(100) NOT NULL, capacite VARCHAR(255) NOT NULL, disponibilite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrainte ADD CONSTRAINT FK_17925A70755C5E8E FOREIGN KEY (id_prof_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574AF6B192E FOREIGN KEY (id_classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A755C5E8E FOREIGN KEY (id_prof_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE matiere_parcours ADD CONSTRAINT FK_2DD9465BF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_parcours ADD CONSTRAINT FK_2DD9465B6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE37A4147F0 FOREIGN KEY (mention_id) REFERENCES mention (id)');
        $this->addSql('ALTER TABLE parcours_classe ADD CONSTRAINT FK_8127164A6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parcours_classe ADD CONSTRAINT FK_8127164A8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrainte DROP FOREIGN KEY FK_17925A70755C5E8E');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574AF6B192E');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A755C5E8E');
        $this->addSql('ALTER TABLE matiere_parcours DROP FOREIGN KEY FK_2DD9465BF46CD258');
        $this->addSql('ALTER TABLE matiere_parcours DROP FOREIGN KEY FK_2DD9465B6E38C0DB');
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE37A4147F0');
        $this->addSql('ALTER TABLE parcours_classe DROP FOREIGN KEY FK_8127164A6E38C0DB');
        $this->addSql('ALTER TABLE parcours_classe DROP FOREIGN KEY FK_8127164A8F5EA509');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE contrainte');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_parcours');
        $this->addSql('DROP TABLE mention');
        $this->addSql('DROP TABLE parcours');
        $this->addSql('DROP TABLE parcours_classe');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE salle');
    }
}
