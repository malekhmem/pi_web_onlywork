<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411224543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annoncef (idf INT AUTO_INCREMENT NOT NULL, idu INT DEFAULT NULL, nomf VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, emailf VARCHAR(255) NOT NULL, descf INT NOT NULL, INDEX fk_ut (idu), PRIMARY KEY(idf)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonces (ids INT AUTO_INCREMENT NOT NULL, idu INT DEFAULT NULL, noms VARCHAR(255) NOT NULL, emails VARCHAR(255) NOT NULL, numeros INT NOT NULL, adresses VARCHAR(255) DEFAULT NULL, INDEX fk_util (idu), PRIMARY KEY(ids)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blacklist (idb INT AUTO_INCREMENT NOT NULL, descb TEXT NOT NULL, nbrr INT NOT NULL, PRIMARY KEY(idb)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (idc INT AUTO_INCREMENT NOT NULL, nomc VARCHAR(255) NOT NULL, PRIMARY KEY(idc)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (ide INT AUTO_INCREMENT NOT NULL, ids INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, nomss VARCHAR(255) NOT NULL, INDEX pk_foreigens (ids), PRIMARY KEY(ide)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (idm INT AUTO_INCREMENT NOT NULL, idff INT DEFAULT NULL, nomm VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, descrp TEXT NOT NULL, INDEX fk_mat (idff), PRIMARY KEY(idm)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (idp INT AUTO_INCREMENT NOT NULL, idu INT DEFAULT NULL, idcc INT DEFAULT NULL, nomp VARCHAR(255) NOT NULL, domaine VARCHAR(255) NOT NULL, descp TEXT NOT NULL, emailp VARCHAR(255) NOT NULL, INDEX fk_utilisateur (idu), INDEX fk_cat (idcc), PRIMARY KEY(idp)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (idr INT AUTO_INCREMENT NOT NULL, idu INT DEFAULT NULL, idb INT DEFAULT NULL, descr TEXT NOT NULL, nomr VARCHAR(255) NOT NULL, emailr VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX fk_utill (idu), INDEX pk_foreigenb (idb), PRIMARY KEY(idr)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (idu INT AUTO_INCREMENT NOT NULL, nomu VARCHAR(255) NOT NULL, mailu VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, numerou INT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(idu)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annoncef ADD CONSTRAINT FK_A645688499B902AD FOREIGN KEY (idu) REFERENCES utilisateur (idu)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F99B902AD FOREIGN KEY (idu) REFERENCES utilisateur (idu)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E70DAA798 FOREIGN KEY (ids) REFERENCES annonces (ids)');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091BFC20C25 FOREIGN KEY (idff) REFERENCES annoncef (idf)');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FAB99B902AD FOREIGN KEY (idu) REFERENCES utilisateur (idu)');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FABB2DF0CEF FOREIGN KEY (idcc) REFERENCES categorie (idc)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640499B902AD FOREIGN KEY (idu) REFERENCES utilisateur (idu)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064041A6A876A FOREIGN KEY (idb) REFERENCES blacklist (idb)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncef DROP FOREIGN KEY FK_A645688499B902AD');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F99B902AD');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E70DAA798');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091BFC20C25');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FAB99B902AD');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FABB2DF0CEF');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640499B902AD');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064041A6A876A');
        $this->addSql('DROP TABLE annoncef');
        $this->addSql('DROP TABLE annonces');
        $this->addSql('DROP TABLE blacklist');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
