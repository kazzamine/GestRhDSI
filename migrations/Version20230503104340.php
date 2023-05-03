<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503104340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devision (id INT AUTO_INCREMENT NOT NULL, direction_id INT DEFAULT NULL, personnels_dev_id INT DEFAULT NULL, nom_devision VARCHAR(255) NOT NULL, type_devision VARCHAR(100) DEFAULT NULL, INDEX IDX_D7B72D60AF73D997 (direction_id), INDEX IDX_D7B72D6053ED7B05 (personnels_dev_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnel (id INT AUTO_INCREMENT NOT NULL, grade_id INT DEFAULT NULL, poste_id INT DEFAULT NULL, service_id INT DEFAULT NULL, direction_id INT DEFAULT NULL, academie_id INT DEFAULT NULL, nom_perso VARCHAR(150) NOT NULL, prenom_perso VARCHAR(150) NOT NULL, cin VARCHAR(50) NOT NULL, ppr VARCHAR(255) NOT NULL, sexe VARCHAR(20) NOT NULL, date_naiss DATE NOT NULL, mail VARCHAR(255) NOT NULL, telephone VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A6BCF3DEFE19A1A8 (grade_id), INDEX IDX_A6BCF3DEA0905086 (poste_id), INDEX IDX_A6BCF3DEED5CA9E6 (service_id), INDEX IDX_A6BCF3DEAF73D997 (direction_id), INDEX IDX_A6BCF3DEB38A0D28 (academie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, devision_id INT DEFAULT NULL, nom_service VARCHAR(100) NOT NULL, description_service VARCHAR(255) DEFAULT NULL, respo_service VARCHAR(100) DEFAULT NULL, INDEX IDX_E19D9AD25BB97207 (devision_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE devision ADD CONSTRAINT FK_D7B72D60AF73D997 FOREIGN KEY (direction_id) REFERENCES direction (id)');
        $this->addSql('ALTER TABLE devision ADD CONSTRAINT FK_D7B72D6053ED7B05 FOREIGN KEY (personnels_dev_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DEFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DEA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DEED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DEAF73D997 FOREIGN KEY (direction_id) REFERENCES direction (id)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DEB38A0D28 FOREIGN KEY (academie_id) REFERENCES academie (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD25BB97207 FOREIGN KEY (devision_id) REFERENCES devision (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devision DROP FOREIGN KEY FK_D7B72D60AF73D997');
        $this->addSql('ALTER TABLE devision DROP FOREIGN KEY FK_D7B72D6053ED7B05');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DEFE19A1A8');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DEA0905086');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DEED5CA9E6');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DEAF73D997');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DEB38A0D28');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD25BB97207');
        $this->addSql('DROP TABLE devision');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('DROP TABLE service');
    }
}
