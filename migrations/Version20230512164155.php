<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512164155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conge_jours (id INT AUTO_INCREMENT NOT NULL, personnelcin_id INT DEFAULT NULL, nombre_conge_normal INT NOT NULL, nombre_conge_excep INT NOT NULL, UNIQUE INDEX UNIQ_DE7C2D2C4488D25B (personnelcin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jour_ferier (id INT AUTO_INCREMENT NOT NULL, nom_jour VARCHAR(255) NOT NULL, date_debut_jour DATE NOT NULL, date_fin_jour DATE NOT NULL, duree INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conge_jours ADD CONSTRAINT FK_DE7C2D2C4488D25B FOREIGN KEY (personnelcin_id) REFERENCES personnel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conge_jours DROP FOREIGN KEY FK_DE7C2D2C4488D25B');
        $this->addSql('DROP TABLE conge_jours');
        $this->addSql('DROP TABLE jour_ferier');
    }
}
