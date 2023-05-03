<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411224123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annoncef DROP FOREIGN KEY fk_ut');
        $this->addSql('ALTER TABLE annoncef CHANGE idu idu INT DEFAULT NULL, CHANGE descf descf INT NOT NULL');
        $this->addSql('ALTER TABLE annoncef ADD CONSTRAINT FK_A645688499B902AD FOREIGN KEY (idu) REFERENCES utilisateur (idu)');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY fk_util');
        $this->addSql('ALTER TABLE annonces CHANGE idu idu INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F99B902AD FOREIGN KEY (idu) REFERENCES utilisateur (idu)');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY fk_uu');
        $this->addSql('DROP INDEX fk_uu ON materiel');
        $this->addSql('ALTER TABLE materiel DROP idu, DROP image, CHANGE idff idff INT DEFAULT NULL, CHANGE descm descrp TEXT NOT NULL');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY fk_utilisateur');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FAB99B902AD FOREIGN KEY (idu) REFERENCES utilisateur (idu)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY fk_utill');
        $this->addSql('ALTER TABLE reclamation CHANGE idu idu INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640499B902AD FOREIGN KEY (idu) REFERENCES utilisateur (idu)');
        $this->addSql('ALTER TABLE utilisateur MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD nomu VARCHAR(255) NOT NULL, ADD mailu VARCHAR(255) NOT NULL, ADD mdp VARCHAR(255) NOT NULL, DROP login, DROP password, DROP nom, DROP prenom, DROP email, DROP etat, CHANGE id idu INT AUTO_INCREMENT NOT NULL, CHANGE num_tel numerou INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD PRIMARY KEY (idu)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE annoncef DROP FOREIGN KEY FK_A645688499B902AD');
        $this->addSql('ALTER TABLE annoncef CHANGE idu idu INT NOT NULL, CHANGE descf descf TEXT NOT NULL');
        $this->addSql('ALTER TABLE annoncef ADD CONSTRAINT fk_ut FOREIGN KEY (idu) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F99B902AD');
        $this->addSql('ALTER TABLE annonces CHANGE idu idu INT NOT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT fk_util FOREIGN KEY (idu) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE materiel ADD idu INT NOT NULL, ADD image VARCHAR(255) NOT NULL, CHANGE idff idff INT NOT NULL, CHANGE descrp descm TEXT NOT NULL');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT fk_uu FOREIGN KEY (idu) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX fk_uu ON materiel (idu)');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FAB99B902AD');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT fk_utilisateur FOREIGN KEY (idu) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640499B902AD');
        $this->addSql('ALTER TABLE reclamation CHANGE idu idu INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT fk_utill FOREIGN KEY (idu) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur MODIFY idu INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD login VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD etat VARCHAR(255) NOT NULL, DROP nomu, DROP mailu, DROP mdp, CHANGE idu id INT AUTO_INCREMENT NOT NULL, CHANGE numerou num_tel INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD PRIMARY KEY (id)');
    }
}
