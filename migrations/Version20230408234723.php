<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408234723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annoncef CHANGE idu idu INT DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel CHANGE idff idff INT DEFAULT NULL');
        $this->addSql('ALTER TABLE poste CHANGE idcc idcc INT DEFAULT NULL, CHANGE idu idu INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE idu idu INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE annoncef CHANGE idu idu INT NOT NULL');
        $this->addSql('ALTER TABLE materiel CHANGE idff idff INT NOT NULL');
        $this->addSql('ALTER TABLE poste CHANGE idu idu INT NOT NULL, CHANGE idcc idcc INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE idu idu INT NOT NULL');
    }
}
