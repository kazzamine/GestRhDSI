<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502095158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE academie (id INT AUTO_INCREMENT NOT NULL, ministre_academie_id INT DEFAULT NULL, nom_academie VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(100) DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, INDEX IDX_A9373E3D3B4BBCEE (ministre_academie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE direction (id INT AUTO_INCREMENT NOT NULL, ministere_d_id INT DEFAULT NULL, nom_direction VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, INDEX IDX_3E4AD1B315F338B2 (ministere_d_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, nom_grade VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ministre (id INT AUTO_INCREMENT NOT NULL, nom_ministre VARCHAR(200) NOT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, nom_poste VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE academie ADD CONSTRAINT FK_A9373E3D3B4BBCEE FOREIGN KEY (ministre_academie_id) REFERENCES ministre (id)');
        $this->addSql('ALTER TABLE direction ADD CONSTRAINT FK_3E4AD1B315F338B2 FOREIGN KEY (ministere_d_id) REFERENCES ministre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE academie DROP FOREIGN KEY FK_A9373E3D3B4BBCEE');
        $this->addSql('ALTER TABLE direction DROP FOREIGN KEY FK_3E4AD1B315F338B2');
        $this->addSql('DROP TABLE academie');
        $this->addSql('DROP TABLE direction');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE ministre');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
