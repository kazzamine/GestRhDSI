<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512103918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel ADD devision_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DE5BB97207 FOREIGN KEY (devision_id) REFERENCES devision (id)');
        $this->addSql('CREATE INDEX IDX_A6BCF3DE5BB97207 ON personnel (devision_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DE5BB97207');
        $this->addSql('DROP INDEX IDX_A6BCF3DE5BB97207 ON personnel');
        $this->addSql('ALTER TABLE personnel DROP devision_id');
    }
}
