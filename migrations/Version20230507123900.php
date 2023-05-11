<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507123900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, employe_abse_id INT DEFAULT NULL, type_absence VARCHAR(255) NOT NULL, date_debut_absence DATE NOT NULL, date_fin_absence DATE NOT NULL, justification VARCHAR(255) NOT NULL, INDEX IDX_765AE0C91A14DBD1 (employe_abse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire_es (id INT AUTO_INCREMENT NOT NULL, heure_entre TIME NOT NULL, heure_sortie TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C91A14DBD1 FOREIGN KEY (employe_abse_id) REFERENCES personnel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C91A14DBD1');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE horaire_es');
    }
}
