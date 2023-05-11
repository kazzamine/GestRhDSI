<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230511122712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conge (id INT AUTO_INCREMENT NOT NULL, date_debut_conge DATE NOT NULL, date_fin_conge DATE NOT NULL, type_conge INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_conge (id INT AUTO_INCREMENT NOT NULL, personnel_demande_id INT DEFAULT NULL, conge_demande_id INT DEFAULT NULL, INDEX IDX_D8061061878287C5 (personnel_demande_id), INDEX IDX_D8061061E696F665 (conge_demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire_es_personnel (horaire_es_id INT NOT NULL, personnel_id INT NOT NULL, INDEX IDX_1E192C6D1292ABAB (horaire_es_id), INDEX IDX_1E192C6D1C109075 (personnel_id), PRIMARY KEY(horaire_es_id, personnel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_conge (id INT AUTO_INCREMENT NOT NULL, type_conge VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_conge ADD CONSTRAINT FK_D8061061878287C5 FOREIGN KEY (personnel_demande_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE demande_conge ADD CONSTRAINT FK_D8061061E696F665 FOREIGN KEY (conge_demande_id) REFERENCES conge (id)');
        $this->addSql('ALTER TABLE horaire_es_personnel ADD CONSTRAINT FK_1E192C6D1292ABAB FOREIGN KEY (horaire_es_id) REFERENCES horaire_es (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE horaire_es_personnel ADD CONSTRAINT FK_1E192C6D1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_conge DROP FOREIGN KEY FK_D8061061878287C5');
        $this->addSql('ALTER TABLE demande_conge DROP FOREIGN KEY FK_D8061061E696F665');
        $this->addSql('ALTER TABLE horaire_es_personnel DROP FOREIGN KEY FK_1E192C6D1292ABAB');
        $this->addSql('ALTER TABLE horaire_es_personnel DROP FOREIGN KEY FK_1E192C6D1C109075');
        $this->addSql('DROP TABLE conge');
        $this->addSql('DROP TABLE demande_conge');
        $this->addSql('DROP TABLE horaire_es_personnel');
        $this->addSql('DROP TABLE type_conge');
    }
}
