<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525125004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conge ADD duree_conge INT NOT NULL');
        $this->addSql('ALTER TABLE personnel RENAME INDEX mail TO UNIQ_A6BCF3DE5126AC48');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel RENAME INDEX uniq_a6bcf3de5126ac48 TO mail');
        $this->addSql('ALTER TABLE conge DROP duree_conge');
    }
}
